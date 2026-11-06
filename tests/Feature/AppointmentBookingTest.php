<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_page_loads_with_active_services_and_branches(): void
    {
        $service = Service::create([
            'name' => 'Physiotherapy',
            'slug' => 'physiotherapy',
            'is_active' => true,
        ]);
        $branch = $this->makeBranch();

        $this->get(route('appointment.create'))
            ->assertOk()
            ->assertSee($service->name)
            ->assertSee($branch->name);
    }

    public function test_patient_can_submit_a_booking_for_an_available_slot(): void
    {
        $service = Service::create([
            'name' => 'Physiotherapy',
            'slug' => 'physiotherapy',
            'is_active' => true,
        ]);
        $branch = $this->makeBranch();
        $date = Carbon::tomorrow()->addWeek()->toDateString();

        $response = $this->post(route('appointment.store'), [
            'patient_name' => 'Test Patient',
            'phone' => '9812345678',
            'age' => 32,
            'service_id' => $service->id,
            'branch_id' => $branch->id,
            'appointment_date' => $date,
            'appointment_time' => '09:30',
            'symptoms' => 'Shoulder pain',
            'patient_message' => 'Morning appointment preferred.',
        ]);

        $appointment = Appointment::firstOrFail();

        $response->assertRedirect(route('appointment.success', $appointment->booking_reference));
        $this->assertSame('pending', $appointment->status);
        $this->assertSame($branch->id, $appointment->branch_id);
        $this->assertStringStartsWith('ARO-', $appointment->booking_reference);

        $this->get(route('appointment.success', $appointment->booking_reference))
            ->assertOk()
            ->assertSee($appointment->booking_reference);
    }

    public function test_booking_page_exposes_available_branch_slots_as_json(): void
    {
        $branch = $this->makeBranch();
        $date = Carbon::tomorrow()->addWeek()->toDateString();

        $this->getJson(route('appointment.available-slots', [
            'branch_id' => $branch->id,
            'date' => $date,
        ]))
            ->assertOk()
            ->assertJsonPath('available', true)
            ->assertJsonPath('slots.0.value', '09:00')
            ->assertJsonPath('slots.1.value', '09:30');
    }

    public function test_booking_rejects_a_slot_outside_the_branch_schedule(): void
    {
        $service = Service::create([
            'name' => 'Physiotherapy',
            'slug' => 'physiotherapy',
            'is_active' => true,
        ]);
        $branch = $this->makeBranch();

        $this->from(route('appointment.create'))
            ->post(route('appointment.store'), [
                'patient_name' => 'Test Patient',
                'phone' => '9812345678',
                'age' => 32,
                'service_id' => $service->id,
                'branch_id' => $branch->id,
                'appointment_date' => Carbon::tomorrow()->addWeek()->toDateString(),
                'appointment_time' => '15:00',
            ])
            ->assertSessionHasErrors('appointment_time');

        $this->assertDatabaseCount('appointments', 0);
    }

    private function makeBranch(): Branch
    {
        $date = Carbon::tomorrow()->addWeek();

        return Branch::create([
            'name' => 'Main Clinic',
            'slug' => 'main-clinic',
            'address' => '123 Clinic Road',
            'is_active' => true,
            'working_days' => [
                $date->format('l') => [
                    'open' => '09:00',
                    'close' => '12:00',
                    'is_closed' => false,
                ],
            ],
        ]);
    }
}
