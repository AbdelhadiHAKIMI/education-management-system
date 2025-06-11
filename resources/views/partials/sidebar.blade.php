<aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
    <div class="p-4 border-gray-200 border-b">
        <div class="flex items-center space-x-3 space-x-reverse">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'مدير المؤسسة') }}&background=random"
                class="rounded-full w-10 h-10"
                alt="صورة المستخدم">
            <div>
                <p class="font-medium">{{ Auth::user()->name ?? 'اسم المستخدم' }}</p>
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
                <a href="{{ route('admin.levels.dashboard') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fa-layer-group fas"></i>
                    <span>المستويات الدراسية</span>
                </a>
            </li>
            <li x-data="{ open: false }" class="relative">
                <button type="button"
                    @click="open = !open"
                    class="flex items-center space-x-2 space-x-reverse w-full hover:bg-gray-100 p-3 rounded-lg focus:outline-none {{ request()->routeIs('admin.students.*') ? 'bg-blue-100 text-blue-800' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>الطلبة</span>
                    <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">324</span>
                    <i class="ml-1 text-xs fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <ul x-show="open"
                    x-transition
                    class="space-y-1 mt-1"
                    @click.away="open = false">
                    <li>
                        <a href="{{ route('admin.students.index') }}" class="block hover:bg-gray-100 px-8 py-2 rounded-lg text-gray-700">عرض الطلاب</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.students.create') }}" class="block hover:bg-gray-100 px-8 py-2 rounded-lg text-gray-700">إضافة طالب جديد</a>
                    </li>
                    <li>
                        <a href="{{ route('csv.processor') }}" class="block hover:bg-gray-100 px-8 py-2 rounded-lg text-gray-700">استيراد الطلاب (CSV)</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>المؤطرين</span>
                    <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">24</span>
                </a>
            </li>
            <li>
                <a href="/admin/programs/index" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-calendar-alt"></i>
                    <span>البرامج التعليمية</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>الإدارة المالية</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-chart-bar"></i>
                    <span>التقارير والإحصائيات</span>
                </a>
            </li>

            <div class="mt-8 pt-4 border-gray-200 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg w-full text-red-600">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </ul>
    </div>
</aside>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>