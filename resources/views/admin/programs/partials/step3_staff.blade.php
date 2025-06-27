<div class="space-y-6 sm:space-y-8">
    <!-- Supervisors -->
    <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
        <h4 class="mb-3 font-medium text-gray-800 text-md">المشرفون</h4>
        <div class="gap-2 sm:gap-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($filteredStaff as $s)
            @if($s->type == 'مؤطر دراسي')
            <label class="flex items-center hover:bg-primary/5 p-3 border border-gray-200 hover:border-primary/30 rounded-lg transition-colors duration-200 cursor-pointer">
                <input type="checkbox" name="supervisor_ids[]" value="{{ $s->id }}" class="border-gray-300 rounded focus:ring-primary/50 w-5 h-5 text-primary transition-colors duration-200">
                <span class="ml-3 text-gray-800 text-sm">{{ $s->full_name }}</span>
            </label>
            @endif
            @endforeach
        </div>
    </div>
    <!-- Teachers -->
    <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
        <h4 class="mb-3 font-medium text-gray-800 text-md">الأساتذة</h4>
        <div class="gap-2 sm:gap-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($filteredStaff as $s)
            @if($s->type == 'أستاذ')
            <label class="flex items-center hover:bg-primary/5 p-3 border border-gray-200 hover:border-primary/30 rounded-lg transition-colors duration-200 cursor-pointer">
                <input type="checkbox" name="teacher_ids[]" value="{{ $s->id }}" class="border-gray-300 rounded focus:ring-primary/50 w-5 h-5 text-primary transition-colors duration-200">
                <span class="ml-3 text-gray-800 text-sm">{{ $s->full_name }}</span>
            </label>
            @endif
            @endforeach
        </div>
    </div>
    <!-- Admins -->
    <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
        <h4 class="mb-3 font-medium text-gray-800 text-md">الإداريون</h4>
        <div class="gap-2 sm:gap-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($filteredStaff as $s)
            @if($s->type == 'إداري')
            <label class="flex items-center hover:bg-primary/5 p-3 border border-gray-200 hover:border-primary/30 rounded-lg transition-colors duration-200 cursor-pointer">
                <input type="checkbox" name="admin_ids[]" value="{{ $s->id }}" class="border-gray-300 rounded focus:ring-primary/50 w-5 h-5 text-primary transition-colors duration-200">
                <span class="ml-3 text-gray-800 text-sm">{{ $s->full_name }}</span>
            </label>
            @endif
            @endforeach
        </div>
    </div>
</div>