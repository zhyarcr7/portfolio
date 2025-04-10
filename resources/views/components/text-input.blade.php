@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-blue-900/90 dark:text-gray-300 focus:border-[#FF750F] focus:ring-[#FF750F] dark:focus:border-[#FF750F] dark:focus:ring-[#FF750F] rounded-md shadow-sm']) }}>
