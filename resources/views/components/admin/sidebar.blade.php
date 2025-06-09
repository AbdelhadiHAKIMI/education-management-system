{{-- filepath: resources/views/components/admin/sidebar.blade.php --}}
<aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
    <div class="p-4 border-gray-200 border-b">
        <div class="flex items-center space-x-3 space-x-reverse">
            <img src="https://ui-avatars.com/api/?name=مدير+المؤسسة&background=random" 
                 class="rounded-full w-10 h-10" 
                 alt="صورة المستخدم">
            <div>
                <p class="font-medium">
                    {{ session('establishment')->name ?? (auth()->user()->establishment->name ?? '') }}
                </p>
                <p class="text-gray-500 text-xs">مدير المؤسسة</p>
            </div>
        </div>
    </div>
    <div class="p-4">
        <ul class="space-y-2 mt-4">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>لوحة التحكم</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fa-layer-group fas"></i>
                    <span>المستويات الدراسية</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.students.index', ['establishment' => (session('establishment')->id ?? (auth()->user()->establishment->id ?? '')) ]) }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-users"></i>
                    <span>الطلاب</span>
                    <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">324</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>الأساتذة</span>
                    <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">24</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.programs.index') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-calendar-alt"></i>
                    <span>البرامج التعليمية</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-user-check"></i>
                    <span>الحضور والغياب</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>المدفوعات المالية</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-chart-bar"></i>
                    <span>التقارير والإحصائيات</span>
                </a>
            </li>
            <div class="mt-8 pt-4 border-gray-200 border-t">
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg text-red-600">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل الخروج</span>
                </a>
            </div>
        </ul>
    </div>
</aside>