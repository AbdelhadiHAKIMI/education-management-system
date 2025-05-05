@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-gray-800 text-xl leading-tight">
    إدارة المؤسسات التعليمية
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="bg-white p-6 border-gray-200 border-b">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-medium text-lg">قائمة المؤسسات</h3>
                    <a href="{{ route('webmaster.establishments.create') }}" class="flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-white">
                        <i class="ml-2 fas fa-plus"></i>
                        إضافة مؤسسة جديدة
                    </a>
                </div>
                
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">#</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">المؤسسة</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">المدير</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الطلاب</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الحالة</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-right">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">1</td>
                                    <td class="px-4 py-3 font-medium">
                                        <div class="flex items-center space-x-3 space-x-reverse">
                                            <div class="bg-blue-100 p-2 rounded-full">
                                                <i class="text-blue-600 fas fa-school"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold">ثانوية الإخوة عمور</p>
                                                <p class="text-gray-500 text-sm">البليدة</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">عبد القادر بن عمر</td>
                                    <td class="px-4 py-3">324</td>
                                    <td class="px-4 py-3">
                                        <span class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm">نشطة</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2 space-x-reverse">
                                            <a href="{{ route('webmaster.establishments.show', 1) }}" class="hover:bg-blue-50 p-2 rounded-full text-blue-600 hover:text-blue-800" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('webmaster.establishments.edit', 1) }}" class="hover:bg-yellow-50 p-2 rounded-full text-yellow-600 hover:text-yellow-800" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="hover:bg-red-50 p-2 rounded-full text-red-600 hover:text-red-800" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="flex justify-between items-center px-4 py-3 border-gray-200 border-t">
                        <div class="flex flex-1 justify-between items-center">
                            <button class="inline-flex relative items-center bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 text-sm">
                                السابق
                            </button>
                            <div class="hidden md:flex space-x-1 space-x-reverse">
                                <button class="bg-blue-600 px-3 py-1 rounded-md text-white">1</button>
                                <button class="hover:bg-gray-100 px-3 py-1 rounded-md">2</button>
                                <button class="hover:bg-gray-100 px-3 py-1 rounded-md">3</button>
                            </div>
                            <button class="inline-flex relative items-center bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 text-sm">
                                التالي
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection