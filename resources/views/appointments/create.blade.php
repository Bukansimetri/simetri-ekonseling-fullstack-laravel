<x-layout>
    <div class="main-content">
        <!-- Counselor Info -->
        <div class="appointment-header">
            <div class="counselor-avatar" style="background-image: url('{{ asset('storage/'.$counselor->image) }}')"></div>
            <div class="counselor-info">
                <h3>{{ $counselor->name }}</h3>
                <p>{{ $counselor->education }}</p>
                <div class="counselor-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span>({{ rand(50, 200) }} ulasan)</span>
                </div>
            </div>
        </div>

        <!-- Appointment Form -->
        <div class="appointment-form-container">
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <input type="hidden" name="counselor_id" value="{{ $counselor->id }}">

                <!-- Date Section -->
                <div class="form-group">
                    <label for="appointmentDate">Tanggal Konseling</label>
                    <input type="date" name="appointment_date" id="appointmentDate" class="form-control" min="{{ now()->toDateString() }}" required>
                    @error('scheduled_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Section -->
                <div class="form-group">
                    <label>Pilih Waktu</label>
                    <div class="time-slots">
                        @foreach($timeSlots as $time)
                            @php
                                $isBooked = in_array($time, $bookedTimes);
                            @endphp
                            <div class="time-slot {{ $isBooked ? 'booked' : '' }}"
                                data-time="{{ $time }}">
                                {{ $time }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="form-group">
                    <label for="notes">Catatan untuk Konselor (Opsional)</label>
                    <textarea name="notes" id="notes" class="form-control" placeholder="Tuliskan catatan tambahan untuk konselor">{{ old('notes') }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Buat Janji</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slots = document.querySelectorAll('.time-slot:not(.booked)');

    slots.forEach(slot => {
        slot.addEventListener('click', function() {
            document.querySelector('.time-slot.selected')?.classList.remove('selected');
            this.classList.add('selected');

            // Update hidden input for time
            if (!document.querySelector('input[name="appointment_time"]')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'appointment_time';
                document.querySelector('form').appendChild(input);
            }
            document.querySelector('input[name="appointment_time"]').value = this.dataset.time;
        });
    });
});
</script>
@endpush
