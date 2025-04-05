<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View CV') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.zhyar-cv.edit', $zhyarCv) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.zhyar-cv.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">{{ $zhyarCv->professional_title }}</h3>
                            
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $zhyarCv->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} mr-2">
                                        {{ $zhyarCv->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Last Updated: {{ $zhyarCv->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Professional Summary</h4>
                                <p class="text-gray-700 dark:text-gray-300">{{ $zhyarCv->summary }}</p>
                            </div>
                            
                            @if($zhyarCv->cv_file)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">CV File</h4>
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $zhyarCv->cv_file }}</span>
                                        <a href="{{ asset('storage/cv_files/' . $zhyarCv->cv_file) }}" target="_blank" class="ml-2 text-blue-500 hover:underline">View</a>
                                        <a href="{{ asset('storage/cv_files/' . $zhyarCv->cv_file) }}" download class="ml-2 text-green-500 hover:underline">Download</a>
                                    </div>
                                </div>
                            @endif
                            
                            @if($zhyarCv->languages)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Languages</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($zhyarCv->languages as $language)
                                            <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $language['name'] }}</div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $language['proficiency'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            @if($zhyarCv->skills)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Skills</h4>
                                    <div class="space-y-4">
                                        @php
                                            $skillsData = is_string($zhyarCv->skills) ? json_decode($zhyarCv->skills, true) : $zhyarCv->skills;
                                        @endphp
                                        
                                        @if(is_array($skillsData))
                                            @foreach($skillsData as $category => $skills)
                                                <div>
                                                    <h5 class="font-medium text-gray-800 dark:text-gray-200">{{ $category }}</h5>
                                                    <div class="flex flex-wrap gap-2 mt-1">
                                                        @foreach($skills as $skill)
                                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded text-sm">{{ $skill }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div>
                                                <p class="text-gray-500">Skills data format is invalid.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            @if($zhyarCv->certifications)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Certifications</h4>
                                    <div class="space-y-3">
                                        @php
                                            $certificationsData = is_string($zhyarCv->certifications) ? json_decode($zhyarCv->certifications, true) : $zhyarCv->certifications;
                                        @endphp
                                        
                                        @if(is_array($certificationsData))
                                            @foreach($certificationsData as $certification)
                                                <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">
                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $certification['name'] }} ({{ $certification['year'] }})</div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $certification['issuer'] }}</div>
                                                    @if(isset($certification['description']))
                                                        <div class="text-sm mt-1 text-gray-700 dark:text-gray-300">{{ $certification['description'] }}</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div>
                                                <p class="text-gray-500">Certifications data format is invalid.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Education Section -->
            @if($zhyarCv->education)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Education</h3>
                        <div class="space-y-6">
                            @php
                                $educationData = is_string($zhyarCv->education) ? json_decode($zhyarCv->education, true) : $zhyarCv->education;
                            @endphp
                            
                            @if(is_array($educationData))
                                @foreach($educationData as $education)
                                    <div class="border-l-4 border-indigo-500 pl-4 py-1">
                                        <div class="flex justify-between items-start">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $education['degree'] }}</h4>
                                            <span class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-600 dark:text-gray-400">{{ $education['year_start'] }} - {{ $education['year_end'] }}</span>
                                        </div>
                                        <div class="text-gray-700 dark:text-gray-300">{{ $education['institution'] }}</div>
                                        <div class="text-sm text-orange-500 dark:text-orange-400">{{ $education['location'] }}</div>
                                        @if(isset($education['description']))
                                            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $education['description'] }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div>
                                    <p class="text-gray-500">Education data format is invalid.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Work Experience Section -->
            @if($zhyarCv->experience)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Work Experience</h3>
                        <div class="space-y-6">
                            @php
                                $experienceData = is_string($zhyarCv->experience) ? json_decode($zhyarCv->experience, true) : $zhyarCv->experience;
                            @endphp
                            
                            @if(is_array($experienceData))
                                @foreach($experienceData as $experience)
                                    <div class="border-l-4 border-orange-500 pl-4 py-1">
                                        <div class="flex justify-between items-start">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $experience['position'] }}</h4>
                                            <span class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-600 dark:text-gray-400">{{ $experience['year_start'] }} - {{ $experience['year_end'] }}</span>
                                        </div>
                                        <div class="text-gray-700 dark:text-gray-300">{{ $experience['company'] }}</div>
                                        <div class="text-sm text-orange-500 dark:text-orange-400">{{ $experience['location'] }}</div>
                                        @if(isset($experience['responsibilities']) && count($experience['responsibilities']) > 0)
                                            <div class="mt-2">
                                                <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                                    @foreach($experience['responsibilities'] as $responsibility)
                                                        <li>{{ $responsibility }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div>
                                    <p class="text-gray-500">Experience data format is invalid.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 