@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto p-6">

   <div 
    x-data="{ 
        tab: new URLSearchParams(window.location.search).get('tab') || 'full' 
    }" 
    class="space-y-6"
>


        <!-- TAB BUTTONS -->
        <div class="flex space-x-4 border-b pb-2">
            <button 
                @click="tab = 'full'"
                :class="tab === 'full' ? 'bg-green-700 text-white' : 'bg-gray-200'"
                class="px-4 py-2 rounded-lg font-semibold">
                📄 Full Report
            </button>

            <button 
                @click="tab = 'respond'"
                :class="tab === 'respond' ? 'bg-green-700 text-white' : 'bg-gray-200'"
                class="px-4 py-2 rounded-lg font-semibold">
                📝 Respond
            </button>

            <button 
                @click="tab = 'viewresponse'"
                :class="tab === 'viewresponse' ? 'bg-green-700 text-white' : 'bg-gray-200'"
                class="px-4 py-2 rounded-lg font-semibold">
                ⚙️ View Response
           </button>



            <button 
                @click="tab = 'feedback'"
                :class="tab === 'feedback' ? 'bg-green-700 text-white' : 'bg-gray-200'"
                class="px-4 py-2 rounded-lg font-semibold">
                ⭐ Feedback
            </button>
        </div>

        <!-- ================= TAB 1: FULL REPORT ================= -->
        <div x-show="tab === 'full'" x-cloak>
            @include('admin.reports.partials.full_report_section', ['report' => $report])

        </div>

        <!-- ================= TAB 2: RESPOND FORM ================= -->
        <div x-show="tab === 'respond'" x-cloak>
          @include('admin.reports.response', [
        'report' => $report,
        'response' => $report->response  // ← IMPORTANT
    ])

        </div>

        <!-- ================= TAB: VIEW RESPONSE ================= -->
<div x-show="tab === 'viewresponse'" x-cloak>
    @include('admin.reports.partials.viewresponse', [
    'report' => $report,
    'response' => $response
])

</div>



        <!-- ================= TAB 4: FEEDBACK ================= -->
        <div x-show="tab === 'feedback'" x-cloak>
    @include('admin.reports.partials.feedback_review', [
        'report' => $report,
        'feedback' => $feedback
    ])
</div>


    </div>
</div>
@endsection
