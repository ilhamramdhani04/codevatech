<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\DiagnosisHistory;
use App\Models\DiagnosisResult;
use App\Models\Kategori;
use App\Models\Kerusakan;
use App\Models\LaptopModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_brand_details_through_a_real_link(): void
    {
        $brand = Brand::create(['nama_brand' => 'ASUS']);
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->get('/admin/analytics')->assertOk()
            ->assertSee('href="'.route('admin.analytics.index', ['brand_id' => $brand->id]).'"', false);
        $this->get('/admin/analytics?brand_id='.$brand->id)->assertOk()
            ->assertSee('Analisis Detail Kerusakan Brand: ASUS')
            ->assertSee('Kembali ke Overview Brand');
    }

    public function test_brand_model_and_date_filters_return_only_matching_damage_results(): void
    {
        $brand = Brand::create(['nama_brand' => 'ASUS']);
        $otherBrand = Brand::create(['nama_brand' => 'Acer']);
        $model = LaptopModel::create(['brand_id' => $brand->id, 'nama_model' => 'Zenbook']);
        $otherModel = LaptopModel::create(['brand_id' => $brand->id, 'nama_model' => 'ROG']);
        $category = Kategori::create(['nama_kategori' => 'Hardware']);
        $damage = Kerusakan::create(['kategori_id' => $category->id, 'kode_kerusakan' => 'K01', 'nama_kerusakan' => 'RAM']);
        foreach ([[$brand->id, $model->id, now()], [$brand->id, $otherModel->id, now()], [$brand->id, $model->id, now()->subDays(40)], [$otherBrand->id, null, now()]] as [$brandId, $modelId, $date]) {
            $history = DiagnosisHistory::create(['brand_id' => $brandId, 'laptop_model_id' => $modelId, 'tanggal_diagnosis' => $date]);
            DiagnosisResult::create(['diagnosis_history_id' => $history->id, 'kerusakan_id' => $damage->id]);
        }

        $query = http_build_query(['brand_id' => $brand->id, 'laptop_model_id' => $model->id, 'start_date' => now()->subDays(7)->toDateString(), 'end_date' => now()->toDateString()]);
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->getJson('/admin/analytics/data?'.$query)->assertOk()->assertJsonPath('success', true)
            ->assertJsonPath('analytics.active_brand_name', 'ASUS')
            ->assertJsonPath('analytics.active_model_name', 'Zenbook')
            ->assertJsonPath('analytics.total_cases', 1)
            ->assertJsonPath('analytics.damage_breakdown.data.0.kode_kerusakan', 'K01')
            ->assertJsonCount(2, 'laptopModels');
    }

    public function test_paginated_analytics_preserves_raw_damage_totals_and_filter_links(): void
    {
        $brand = Brand::create(['nama_brand' => 'ASUS']);
        $category = Kategori::create(['nama_kategori' => 'Hardware']);
        $history = DiagnosisHistory::create(['brand_id' => $brand->id, 'tanggal_diagnosis' => now()]);
        foreach (range(1, 12) as $number) {
            $damage = Kerusakan::create(['kategori_id' => $category->id, 'kode_kerusakan' => 'K'.$number, 'nama_kerusakan' => 'Kerusakan '.$number]);
            DiagnosisResult::create(['diagnosis_history_id' => $history->id, 'kerusakan_id' => $damage->id]);
        }

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->getJson('/admin/analytics/data?brand_id='.$brand->id.'&page=2')
            ->assertOk()->assertJsonPath('analytics.damage_breakdown.current_page', 2)
            ->assertJsonPath('analytics.damage_breakdown.total', 12)
            ->assertJsonCount(2, 'analytics.damage_breakdown.data')
            ->assertJsonCount(12, 'analytics.damage_breakdown_raw')
            ->assertJsonPath('analytics.active_brand_id', (string) $brand->id)
            ->assertJsonPath('analytics.total_cases', 12);
    }

    public function test_brand_without_cases_returns_an_empty_detail_dataset(): void
    {
        $brand = Brand::create(['nama_brand' => 'Advan']);
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->getJson('/admin/analytics/data?brand_id='.$brand->id)->assertOk()
            ->assertJsonPath('analytics.total_cases', 0)
            ->assertJsonPath('analytics.active_brand_name', 'Advan')
            ->assertJsonCount(0, 'analytics.damage_breakdown.data')
            ->assertJsonCount(0, 'analytics.damage_breakdown_raw')
            ->assertJsonCount(0, 'laptopModels');
    }

    public function test_guest_cannot_access_analytics_or_its_data(): void
    {
        $this->get('/admin/analytics')->assertRedirect('/admin/login');
        $this->get('/admin/analytics/data')->assertRedirect('/admin/login');
    }

    public function test_teknisi_cannot_access_admin_analytics_or_its_data(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'teknisi']));
        $this->get('/admin/analytics')->assertForbidden();
        $this->get('/admin/analytics/data')->assertForbidden();
    }
}
