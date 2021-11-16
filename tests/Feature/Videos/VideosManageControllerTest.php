<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function regular_users_cannot_manage_videos(){

        $this->loginAsRegularUser();

        $response = $this->get('/manage/videos');

        $response->assertStatus(403);
    }
    /**
     * @test
     */
    public function guest_users_cannot_manage_videos(){
        $response = $this->get('/manage/videos');

        $response->assertRedirect('login');
    }
    /**
     * @test
     */
    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);

        $response->assertViewIs('videos.manage.index');
    }
    /**
     * @test
     */
    private function loginAsVideoManager()
    {
        Auth::login(create_video_manager_user());
    }
    /**
     * @test
     */
    private function loginAsSuperAdmin()
    {

        Auth::login(create_superadmin_user());
    }

    private function loginAsRegularUser()
    {
        Auth::login(create_regular_user());
    }
}
