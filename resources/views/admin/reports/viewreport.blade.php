@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">

    <div
        x-data="{
            tab: new URLSearchParams(window.location.search).get('tab') || 'full'
        }"
        class="space-y-6"
    >

        <!-- ================= TAB BUTTONS ================= -->
        <div class="flex flex-wrap gap-2 border-b pb-2">
            <button
                @click="tab = 'full'"
                :class="tab === 'full'
                    ? 'bg-green-700 text-white shadow'
                    : 'bg-gray-200 hover:bg-gray-300'"
                class="px-4 py-2 rounded-lg font-semibold transition">
                📄 Full Report
            </button>

            <button
                @click="tab = 'respond'"
                :class="tab === 'respond'
                    ? 'bg-green-700 text-white shadow'
                    : 'bg-gray-200 hover:bg-gray-300'"
                class="px-4 py-2 rounded-lg font-semibold transition">
                📝 Respond
            </button>

            <button
                @click="tab = 'viewresponse'"
                :class="tab === 'viewresponse'
                    ? 'bg-green-700 text-white shadow'
                    : 'bg-gray-200 hover:bg-gray-300'"
                class="px-4 py-2 rounded-lg font-semibold transition">
                ⚙️ View Response
            </button>

            <button
                @click="tab = 'feedback'"
                :class="tab === 'feedback'
                    ? 'bg-green-700 text-white shadow'
                    : 'bg-gray-200 hover:bg-gray-300'"
                class="px-4 py-2 rounded-lg font-semibold transition">
                ⭐ Feedback
            </button>
        </div>

        <!-- ================= TAB: FULL REPORT ================= -->
        <div x-show="tab === 'full'" x-cloak>
            {{-- IMPORTANT: use the merged full report partial --}}
            @include('admin.reports.partials.full_report_section', [
                'report' => $report
            ])
        </div>

        <!-- ================= TAB: RESPOND ================= -->
        <div x-show="tab === 'respond'" x-cloak>
            <div class="bg-white shadow-md rounded-lg p-6">
                @include('admin.reports.response', [
                    'report'   => $report,
                    'response' => $report->response
                ])
            </div>
        </div>

        <!-- ================= TAB: VIEW RESPONSE ================= -->
        <div x-show="tab === 'viewresponse'" x-cloak>
            <div class="bg-white shadow-md rounded-lg p-6">
                @include('admin.reports.partials.viewresponse', [
                    'report'   => $report,
                    'response' => $response
                ])
            </div>
        </div>

        <!-- ================= TAB: FEEDBACK ================= -->
        <div x-show="tab === 'feedback'" x-cloak>
            <div class="bg-white shadow-md rounded-lg p-6">
                @include('admin.reports.partials.feedback_review', [
                    'report'   => $report,
                    'feedback' => $feedback
                ])
            </div>
        </div>

    </div>
</div>
@endsection
