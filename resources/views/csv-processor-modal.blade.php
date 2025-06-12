{{-- filepath: resources/views/csv-processor-modal.blade.php --}}
<div id="csvModal" class="hidden z-50 fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 p-4">
    <div class="bg-white shadow-xl p-6 rounded-lg w-full max-w-md">
        <h3 class="mb-4 font-bold text-lg">رفع ملف CSV</h3>
        <form id="csv-upload-form" action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="csv_file" class="block mb-2 font-medium text-gray-700 text-right">اختر ملف CSV</label>
                <input id="csv_file" name="csv_file" type="file" accept=".csv,.xlsx" required
                    class="border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-right">
            </div>
            <div class="mb-4">
                <label for="level_id" class="block mb-2 font-medium text-gray-700 text-right">المستوى الدراسي</label>
                <select id="level_id" name="level_id" class="border border-gray-300 rounded-lg w-full" required>
                    <option value="">اختر المستوى</option>
                    @foreach(\App\Models\Level::all() as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-between items-center">
                <button type="button" onclick="closeCSVModal()"
                    class="hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-700">
                    إلغاء
                </button>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg font-medium text-white">
                    رفع الملف
                </button>
            </div>
        </form>
    </div>
</div>