<!-- Modal Profil Konselor -->
<div id="profileModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display:none;">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 relative w-full max-w-2xl">
        <button type="button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 close">
            &times;
        </button>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="profile-image w-32 h-32 rounded-full bg-gray-200 bg-center bg-cover mx-auto md:mx-0"></div>
            <div>
                <h2 id="profileName" class="text-2xl font-bold mb-2"></h2>
                <p id="profileSpecialty" class="text-gray-600 mb-1"></p>
                <p id="profileBio" class="text-gray-700 mb-3"></p>
                <div class="text-sm text-gray-500 space-y-1">
                    <p><i class="fas fa-money-bill-wave text-primary"></i> <span id="profilePrice"></span></p>
                    <p><i class="fas fa-clock text-primary"></i> <span id="profileAvailability"></span></p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-right">
            <button type="button" class="btn btn-primary open-appointment-modal">Buat Janji</button>
        </div>
    </div>
</div>

<!-- Modal Buat Janji -->
<div id="appointmentModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 relative w-full max-w-lg">
        <button type="button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 close">
            &times;
        </button>
        <h3 class="text-xl font-semibold mb-4">Buat Janji Konseling</h3>
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf
            <input type="hidden" name="counselor_id" id="counselorId">

            <div class="mb-4">
                <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Tanggal Konseling</label>
                <input type="date" name="date" id="appointmentDate" class="form-control" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-4">
                <label for="appointmentTime" class="block text-sm font-medium text-gray-700">Pilih Jam Konseling</label>
                <select name="time" id="appointmentTime" class="form-control" required>
                    <option value="">-- Pilih Waktu --</option>
                    <option value="08:00">08:00 - 09:00</option>
                    <option value="09:00">09:00 - 10:00</option>
                    <option value="10:00">10:00 - 11:00</option>
                    <option value="13:00">13:00 - 14:00</option>
                    <option value="14:00">14:00 - 15:00</option>
                    <option value="15:00">15:00 - 16:00</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="appointmentNotes" class="block text-sm font-medium text-gray-700">Keluhan/Kebutuhan</label>
                <textarea name="notes" id="appointmentNotes" rows="3" class="form-control" placeholder="Ceritakan singkat kebutuhan Anda"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Simpan Janji</button>
            </div>
        </form>
    </div>
</div>
