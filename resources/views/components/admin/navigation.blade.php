{{-- filepath: resources/views/components/admin/navigation.blade.php --}}
<nav class="bg-blue-800 shadow-lg text-white">
    <div class="flex justify-between items-center mx-auto px-4 py-3 container">
        <div class="flex items-center space-x-4 space-x-reverse">
            <i class="text-2xl fas fa-graduation-cap"></i>
            <span class="font-semibold text-xl">ثانوية الإخوة عمور</span>
        </div>
        <div class="flex items-center space-x-6 space-x-reverse">
            <div class="group relative">
                <button class="flex items-center space-x-2 space-x-reverse bg-blue-700 px-3 py-1 rounded-lg">
                    <i class="fas fa-calendar-alt"></i>
                    <span>2023/2024</span>
                    <i class="text-xs fas fa-chevron-down"></i>
                </button>
                <div class="hidden group-hover:block right-0 z-10 absolute bg-white shadow-lg mt-2 rounded-md w-48">
                    <div class="py-1">
                        <div class="bg-gray-100 px-4 py-2 font-semibold text-dark">السنوات الدراسية</div>
                        <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-dark">
                            <span class="font-medium">2023/2024</span>
                            <span class="bg-green-100 mr-2 px-2 py-1 rounded-full text-green-800 text-xs">نشطة</span>
                        </a>
                        <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-dark">2022/2023</a>
                        <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-dark">2021/2022</a>
                        <div class="border-gray-200 border-t"></div>
                        <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-primary">
                            <i class="mr-2 fas fa-plus"></i> سنة جديدة
                        </a>
                    </div>
                </div>
            </div>
            <a href="#" class="relative hover:text-blue-200">
                <i class="fas fa-bell"></i>
                <span class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">5</span>
            </a>
            <div class="flex items-center space-x-2 space-x-reverse">
                <img src="https://ui-avatars.com/api/?name=مدير+المؤسسة&background=random" 
                     class="rounded-full w-8 h-8" 
                     alt="صورة المستخدم">
                <span>مدير المؤسسة</span>
                <i class="text-xs fas fa-chevron-down"></i>
            </div>
        </div>
    </div>
</nav>