<div class="space-y-4">
    <!-- Assigned Evacuation Site (conditional) -->
    @if(in_array($report->type, ['Emergencies', 'Accidents']))
        <p><strong>Evacuation Site:</strong> {{ $report->evacuation_site }}</p>
    @endif

    <!-- Dispatch Unit -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Dispatch Unit</label>
        <select name="dispatch_unit" class="w-full border rounded p-2">
            <option value="" disabled {{ !$report->dispatch_unit ? 'selected' : '' }}>Select dispatch unit</option>
            <option value="Police" {{ $report->dispatch_unit == 'Police' ? 'selected' : '' }}>Police</option>
            <option value="Medical" {{ $report->dispatch_unit == 'Medical' ? 'selected' : '' }}>Medical</option>
            <option value="Barangay" {{ $report->dispatch_unit == 'Barangay' ? 'selected' : '' }}>Barangay</option>
        </select>
    </div>

    <!-- Contact Person -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Person</label>
        <input type="text" name="contact_person" value="{{ $report->contact_person }}"
               placeholder="Juan Dela Cruz"
               class="w-full border rounded p-2">
    </div>

    <!-- Contact Number -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" name="contact_number" value="{{ $report->contact_number }}"
          placeholder="09XX-XXX-XXXX"
          maxlength="11"
          class="w-full border rounded p-2"
          oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)">
    </div>
</div>