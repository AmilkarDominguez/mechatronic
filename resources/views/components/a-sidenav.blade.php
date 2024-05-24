@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-4 py-2 mt-2 text-sm font-semibold text-white bg-primary-400 rounded-full dark-mode:bg-primary-700 dark-mode:hover:bg-primary-600 dark-mode:focus:bg-primary-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-black  focus:text-black hover:text-primary-700 hover:bg-primary-100 shadow-md'
            : 'block px-4 py-2 mt-2 text-sm font-semibold text-gray-500 bg-transparent rounded-full dark-mode:bg-primary-700 dark-mode:hover:bg-primary-600 dark-mode:focus:bg-primary-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-black focus:text-black hover:text-primary-700  hover:bg-primary-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
