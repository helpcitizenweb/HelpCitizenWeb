@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-lg space-y-12">
    {{-- About Section --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">About HelpCitizen</h1>
        <p class="text-gray-700 mb-4">
            HelpCitizen is a web-based community engagement and response system designed to help residents connect with their local barangay. We aim to improve communication, report concerns efficiently, and deliver essential services in a timely and organized manner.
        </p>
        <p class="text-gray-700">
            This platform supports community members by allowing them to submit reports, view local announcements, and access important barangay services conveniently from their devices.
        </p>
    </div>

    {{-- Map Section --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Barangay Hall Location</h2>
        <div class="relative w-full h-64 md:h-96">
            <iframe 
                class="absolute top-0 left-0 w-full h-full rounded-lg border"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7721.690875422901!2d120.96039607574143!3d14.607879176897216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca736884dbf3%3A0x322821fb08a2f641!2sBarangay%2041%20Barangay%20Hall!5e0!3m2!1sen!2sph!4v1753330066688!5m2!1sen!2sph"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    {{-- Contact Section --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact Us</h2>
        <ul class="space-y-6 text-gray-700">
            <li class="flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 12a4 4 0 01-8 0 4 4 0 018 0z"></path>
                    <path d="M12 14v7"></path>
                </svg>
                <div>
                    <p class="font-semibold text-gray-800">Email:</p>
                    <p>helpcitizen@barangay41.com</p>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 5h2l3.6 7.59-1.35 2.44a1 1 0 00.91 1.41h7.72a1 1 0 00.91-1.41L17 12.59 20.4 5H3z"></path>
                </svg>
                <div>
                    <p class="font-semibold text-gray-800">Phone:</p>
                    <p>(02) 8123-4567</p>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3"></path>
                    <path d="M12 1a11 11 0 1 0 0 22 11 11 0 0 0 0-22z"></path>
                </svg>
                <div>
                    <p class="font-semibold text-gray-800">Office Hours:</p>
                    <p>Monday - Friday, 8:00 AM - 5:00 PM</p>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 5a2 2 0 012-2h2a2 2 0 012 2v16l-3-3-3 3V5z"></path>
                    <path d="M17 10h4a2 2 0 012 2v7l-3-3-3 3v-7a2 2 0 012-2z"></path>
                </svg>
                <div>
                    <p class="font-semibold text-gray-800">Address:</p>
                    <p>Barangay Hall, Barangay 41, City of Manila, Philippines</p>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
