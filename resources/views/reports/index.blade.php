@extends('layouts.app')

@section('content')
    <div class="max-w-3xl bg-white p-8 rounded-lg shadow-md mx-auto my-8">

        <h2 class="text-2xl font-bold text-gray-800 p-4">Submit a Report</h2>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="fixed p-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 rounded-lg shadow-lg z-50">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-4">
            @csrf

            <div x-data="{ anonymous: {{ old('anonymous', 0) == 1 ? 'true' : 'false' }} }">

                <div x-show="!anonymous" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    @guest
                        <div x-data="{ anonymous: false }">

                            <!-- Guest-only Fields -->
                            <div x-show="!anonymous" x-transition.duration.300ms class="space-y-4" id="guest-fields"
                                x-bind:style="anonymous ? 'display: none;' : ''">

                                <div>
                                    <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="w-full border-gray-300 rounded-lg shadow-sm" x-bind:required="anonymous"
                                        required>
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="w-full border-gray-300 rounded-lg shadow-sm" x-bind:required="anonymous"
                                        required>
                                </div>

                                <div>
                                    <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number
                                        (Optional)
                                    </label>
                                    <input type="text" name="phone" id="phone"
                                        class="w-full border-gray-300 rounded-lg shadow-sm" x-bind:disabled="anonymous">
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
                <!-- Checkbox -->
                <div class="flex items-center">
                    <input type="hidden" name="anonymous" value="0">
                    <input type="checkbox" name="anonymous" id="anonymous" value="1" x-model="anonymous"
                        class="mr-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="anonymous" class="text-sm text-gray-700 p-2">Submit anonymously</label>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 focus:ring-indigo-500">Type of Report</label>
                    <select id="type" name="type" class="border border-gray-300 rounded-lg p-2 w-full" required>
                        <option value="">Select type</option>
                        <option value="Emergencies">Emergencies</option>
                        <option value="Accidents">Accidents</option>
                        <option value="Complaints">Complaints</option>
                        <option value="Services">Services</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div id="subtype-container" class="mt-4 hidden">
                    <label class="block text-gray-700 font-medium mb-2 focus:ring-indigo-500">Subtype</label>
                    <select id="subtype" name="subtype" class="border border-gray-300 rounded-lg p-2 w-full">
                    </select>
                </div>

                <div id="demographics-container" class="mt-4 hidden">
                    <h4 class="text-gray-700 font-medium mb-2">Demographics</h4>

                    <div>
                        <label for="casualties" class="block text-gray-700 mb-1">Number of Casualties</label>
                        <input type="number" name="casualties" id="casualties" min="0"
                            class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div class="mt-2">
                        <label for="gender" class="block text-gray-700 mb-1">Gender</label>
                        <select name="gender" id="gender" class="w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="">Select gender</option>
                            <option value="Male">Male/s</option>
                            <option value="Female">Female/s</option>
                            <option value="Both">Both</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                    <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-lg shadow-sm"
                        required>
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm"
                        required></textarea>
                </div>

                <div>
                    <label for="location" class="block text-gray-700 font-medium mb-1">Location / Address</label>
                    <textarea name="location" id="location" rows="2"
    class="w-full border-gray-300 rounded-lg shadow-sm"
    placeholder="e.g. Purok 1, near barangay hall"
    required></textarea>

                </div>

                <div>
                    <label for="image" class="block text-gray-700 font-medium mb-1">Upload Image (Required)</label>
                    <input type="file"
    name="image"
    id="image"
    accept="image/*"
    required
    oninvalid="this.setCustomValidity('Please upload an image before submitting')"
    oninput="this.setCustomValidity('')"
    onchange="previewImage(event)"
    class="block w-full text-sm text-gray-700
    file:mr-4 file:py-2 file:px-4
    file:rounded-lg file:border-0
    file:text-sm file:font-semibold
    file:bg-blue-50 file:text-blue-700
    hover:file:bg-blue-100 transition duration-150">


                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">Image Preview:</p>
                        <img id="preview" class="max-w-xs rounded shadow border" alt="Image preview">
                        <button type="button" onclick="removeImage()"
                            class="ml-2 mt-2 px-4 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                            Remove Image
                        </button>
                    </div>
                </div>


                <div class="mt-6">
                    <label for="video" class="block text-gray-700 font-medium mb-1">
                        Upload Video (Required)
                    </label>

                    <input type="file"
    name="video"
    id="video"
    accept="video/*"
    required
    oninvalid="this.setCustomValidity('Please upload a video before submitting')"
    oninput="this.setCustomValidity('')"
    onchange="previewVideo(event)"
    class="block w-full text-sm text-gray-700
    file:mr-4 file:py-2 file:px-4
    file:rounded-lg file:border-0
    file:text-sm file:font-semibold
    file:bg-purple-50 file:text-purple-700
    hover:file:bg-purple-100 transition duration-150">


                    <!-- Video Preview -->
                    <div id="video-preview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">Video Preview:</p>
                        <video id="previewVideoPlayer" controls class="w-64 h-auto rounded shadow border"></video>

                        <button type="button" onclick="removeVideo()"
                            class="ml-2 mt-2 px-4 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                            Remove Video
                        </button>
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-6 py-2 m-8 rounded-lg shadow">
                    Submit Report
                </button>               
        </form>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        
    </div>

    <script>
        const allowedTypes = {
            'Emergencies': ['Fire', 'Flood', 'Earthquake', 'Typhoon', 'Medical', 'Others'],
            'Accidents': ['Traffic', 'Workplace', 'Home', 'Others'],
            'Complaints': ['Noise', 'Garbage', 'Harassment'],
            'Services': ['Public Safety', 'Infrastructure', 'suggestions'],
            'Others': ['Miscellaneous']
        };

        document.getElementById('type').addEventListener('change', function () {
    const subtypeDiv = document.getElementById('subtype-container');
    const subtypeSelect = document.getElementById('subtype');
    const demographicsDiv = document.getElementById('demographics-container');

    // ✅ MISSING VARIABLES (this is what you forgot)
    const casualtiesInput = document.getElementById('casualties');
    const genderSelect = document.getElementById('gender');

    const selectedType = this.value;

    // Reset subtype
    subtypeSelect.innerHTML = '';
    subtypeSelect.required = false;

    // Reset demographics requirements
    casualtiesInput.required = false;
    genderSelect.required = false;

    if (allowedTypes[selectedType]) {
        subtypeDiv.classList.remove('hidden');
        subtypeSelect.required = true;

        let placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Select subtype';
        placeholder.disabled = true;
        placeholder.selected = true;
        subtypeSelect.appendChild(placeholder);

        allowedTypes[selectedType].forEach(sub => {
            let opt = document.createElement('option');
            opt.value = sub;
            opt.textContent = sub;
            subtypeSelect.appendChild(opt);
        });
    } else {
        subtypeDiv.classList.add('hidden');
    }

    // ✅ Demographics required ONLY when visible
    if (selectedType === 'Emergencies' || selectedType === 'Accidents') {
        demographicsDiv.classList.remove('hidden');
        casualtiesInput.required = true;
        genderSelect.required = true;
    } else {
        demographicsDiv.classList.add('hidden');
    }
});



        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                previewContainer.classList.add('hidden');
            }
        }

        function removeImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('image-preview');

            input.value = ''; // Clear file input
            preview.src = '';
            previewContainer.classList.add('hidden');
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function previewVideo(event) {
            const input = event.target;
            const previewContainer = document.getElementById('video-preview');
            const videoPlayer = document.getElementById('previewVideoPlayer');

            if (input.files && input.files[0]) {
                const fileURL = URL.createObjectURL(input.files[0]);
                videoPlayer.src = fileURL;
                previewContainer.classList.remove('hidden');
            } else {
                videoPlayer.src = '';
                previewContainer.classList.add('hidden');
            }
        }

        function removeVideo() {
            const input = document.getElementById('video');
            const videoPlayer = document.getElementById('previewVideoPlayer');
            const previewContainer = document.getElementById('video-preview');

            input.value = '';
            videoPlayer.src = '';
            previewContainer.classList.add('hidden');
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif


@endsection
