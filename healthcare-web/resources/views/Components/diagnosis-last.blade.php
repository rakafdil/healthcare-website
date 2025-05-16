<div class="flex flex-col md:flex-row gap-6">
    <!-- Kondisi List (Left Panel) -->
    <div class="w-full md:w-1/2">
        <h2 class="text-sm font-semibold mb-4">Kondisi-Kondisi yang Memungkinkan</h2>
        <div id="kondisiList" class="space-y-3">
            @foreach (session('diagnosis.result') as $index => $item)
                {{-- @dd($index) --}}
                <button
                    class="w-full text-left py-4 px-6 rounded-xl transition-all duration-300 {{ $index === 0 ? 'bg-blue-200 font-semibold' : 'bg-blue-100' }}"
                    onclick="selectKondisi({{ $index + 1 }})">
                    {{ $item->disease }} ({{ $item->probability * 100 }}%)
                </button>
            @endforeach
        </div>
    </div>

    <!-- Detail Kondisi (Right Panel) -->
    <div class="w-full md:w-3/4 pl-0 md:pl-6">
        <!-- Title at the top -->
        <h1 class="text-2x4 font-semibold mb-6 text-center" id="kondisiTitle">
            {{ session('diagnosis.result')[0]->disease }}</h1>

        <!-- Centered tabs -->
        <div class="flex justify-center mb-6 border-b ">
            <div class="flex gap-8">
                <a href="#"
                    class="px-4 py-2 border-b-2 border-transparent text-gray-500 transition-colors duration-200"
                    id="blogTab" onclick="switchTab('blog')">Blog</a>
                <a href="#"
                    class="px-4 py-2 border-b-2 border-blue-500 text-blue-500 transition-colors duration-200"
                    id="rumahSakitTab" onclick="switchTab('rumahSakit')">Rumah Sakit</a>
            </div>
        </div>

        <!-- Blog Content -->
        <div id="blogContent" class="hidden">
            <div class="grid grid-cols-1 gap-6">
                <!-- Blog content will be populated by JavaScript -->
            </div>
        </div>

        <!-- Rumah Sakit Content (Default) -->
        <div id="rumahSakitContent" class="grid grid-cols-1 gap-6">
            <!-- Article Card 1 -->
            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-1/3 h-48">
                        <img src="/api/placeholder/300/200" alt="Person sick in bed" class="w-full h-full object-cover">
                    </div>
                    <div class="w-full md:w-2/3 p-4">
                        <h3 class="font-semibold mb-2" id="articleTitle1">5 Langkah Mudah Mengatasi Demam
                        </h3>
                        <p class="text-sm text-gray-600 mb-4" id="articleExcerpt1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                            incididunt ut labore.
                        </p>
                        <a href="#"
                            class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">Baca
                            Artikel</a>
                    </div>
                </div>
            </div>

            <!-- Article Card 2 -->
            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-1/3 h-48">
                        <img src="/api/placeholder/300/200" alt="Person sick in bed" class="w-full h-full object-cover">
                    </div>
                    <div class="w-full md:w-2/3 p-4">
                        <h3 class="font-semibold mb-2" id="articleTitle2">5 Langkah Mudah Mengatasi Demam
                        </h3>
                        <p class="text-sm text-gray-600 mb-4" id="articleExcerpt2">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                            incididunt ut labore.
                        </p>
                        <a href="#"
                            class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">Baca
                            Artikel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mt-4">
            <a href="/blog" class="text-blue-500 hover:underline" id="seeMoreLink">See More</a>
        </div>
    </div>
</div>

<script>
    // Sample data for each condition (in a real app, this would come from the backend)
    const kondisiData = {
        1: {
            articles: [{
                    title: "5 Langkah Mudah Mengatasi Demam",
                    excerpt: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.",
                    image: "/api/placeholder/300/200"
                },
                {
                    title: "5 Langkah Mudah Mengatasi Demam",
                    excerpt: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.",
                    image: "/api/placeholder/300/200"
                }
            ],
            hospitals: [{
                    name: "Rumah Sakit Umum Pusat Dr. Cipto Mangunkusumo",
                    address: "Jl. Diponegoro No.71, Jakarta Pusat",
                    distance: "2.5 km",
                    image: "/api/placeholder/300/200"
                },
                {
                    name: "Rumah Sakit Pondok Indah",
                    address: "Jl. Metro Duta Kav. UE, Pondok Indah, Jakarta Selatan",
                    distance: "4.8 km",
                    image: "/api/placeholder/300/200"
                }
            ]
        },
        2: {
            articles: [{
                    title: "Panduan Lengkap Mengatasi Flu",
                    excerpt: "Dolor sit amet consectetur adipiscing elit. Mauris eget felis magna. Praesent ut lectus.",
                    image: "/api/placeholder/300/200"
                },
                {
                    title: "Tips Mengatasi Flu dengan Cara Alami",
                    excerpt: "Consectetur adipiscing elit. Phasellus vitae eros sed nulla varius sollicitudin et non massa.",
                    image: "/api/placeholder/300/200"
                }
            ],
            hospitals: [{
                    name: "Rumah Sakit Medistra",
                    address: "Jl. Gatot Subroto Kav. 59, Jakarta Selatan",
                    distance: "3.2 km",
                    image: "/api/placeholder/300/200"
                },
                {
                    name: "Rumah Sakit Abdi Waluyo",
                    address: "Jl. HOS. Cokroaminoto No.31-33, Menteng, Jakarta Pusat",
                    distance: "5.1 km",
                    image: "/api/placeholder/300/200"
                }
            ]
        },
        3: {
            articles: [{
                    title: "Mengenal Lebih Jauh Tentang Alergi",
                    excerpt: "Etiam ullamcorper augue nec vehicula ultrices. Donec eget orci sit amet massa rutrum pellentesque.",
                    image: "/api/placeholder/300/200"
                },
                {
                    title: "Cara Mencegah Reaksi Alergi",
                    excerpt: "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                    image: "/api/placeholder/300/200"
                }
            ],
            hospitals: [{
                    name: "Rumah Sakit Budi Kemuliaan",
                    address: "Jl. Budi Kemuliaan No.25, Gambir, Jakarta Pusat",
                    distance: "2.9 km",
                    image: "/api/placeholder/300/200"
                },
                {
                    name: "Rumah Sakit MMC",
                    address: "Jl. HR Rasuna Said Kav C-21, Kuningan, Jakarta Selatan",
                    distance: "6.3 km",
                    image: "/api/placeholder/300/200"
                }
            ]
        },
        4: {
            articles: [{
                    title: "Mengenal Gangguan Pencernaan",
                    excerpt: "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                    image: "/api/placeholder/300/200"
                },
                {
                    title: "Diet Sehat untuk Pencernaan",
                    excerpt: "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                    image: "/api/placeholder/300/200"
                }
            ],
            hospitals: [{
                    name: "Rumah Sakit Pertamina Jaya",
                    address: "Jl. Sinabung II, Tebet, Jakarta Selatan",
                    distance: "4.2 km",
                    image: "/api/placeholder/300/200"
                },
                {
                    name: "Rumah Sakit Hermina Jatinegara",
                    address: "Jl. Jatinegara Barat No.126, Jakarta Timur",
                    distance: "7.5 km",
                    image: "/api/placeholder/300/200"
                }
            ]
        }
    };

    // Current tab state
    let currentTab = 'blog';
    let currentKondisi = 1;

    // Function to select a condition
    function selectKondisi(kondisiNumber) {
        currentKondisi = kondisiNumber;

        // Update button styles with animation
        document.querySelectorAll('#kondisiList button').forEach((btn, index) => {
            if (index + 1 === kondisiNumber) {
                btn.classList.add('bg-blue-200', 'font-semibold');
                btn.classList.remove('bg-blue-100');
            } else {
                btn.classList.add('bg-blue-100');
                btn.classList.remove('bg-blue-200', 'font-semibold');
            }
        });

        // Update content
        const kondisi = kondisiData[kondisiNumber];
        // Set the title using the disease name from the session data passed to JS
        const diagnosisResults = @json(session('diagnosis.result'));
        document.getElementById('kondisiTitle').textContent =
            diagnosisResults && diagnosisResults[currentKondisi - 1] ?
            diagnosisResults[currentKondisi - 1].disease :
            `Kondisi ${currentKondisi}`;

        // Update content based on current tab
        updateContent();
    }

    // Function to switch between tabs
    function switchTab(tab) {
        currentTab = tab;

        // Update tab styles
        if (tab === 'blog') {
            document.getElementById('blogTab').classList.add('border-blue-500', 'text-blue-500');
            document.getElementById('blogTab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('rumahSakitTab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('rumahSakitTab').classList.remove('border-blue-500', 'text-blue-500');

            document.getElementById('blogContent').classList.remove('hidden');
            document.getElementById('rumahSakitContent').classList.add('hidden');
            document.getElementById('seeMoreLink').href = '/blog';
        } else {
            document.getElementById('rumahSakitTab').classList.add('border-blue-500', 'text-blue-500');
            document.getElementById('rumahSakitTab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('blogTab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('blogTab').classList.remove('border-blue-500', 'text-blue-500');

            document.getElementById('blogContent').classList.add('hidden');
            document.getElementById('rumahSakitContent').classList.remove('hidden');
            document.getElementById('seeMoreLink').href = '/rumah-sakit';
        }

        // Update content based on selected tab
        updateContent();
    }

    // Function to update content based on current tab and selected condition
    function updateContent() {
        const kondisi = kondisiData[currentKondisi];

        if (currentTab === 'blog') {
            // Populate blog content
            const blogContent = document.getElementById('blogContent');
            blogContent.innerHTML = '';

            kondisi.articles.forEach(article => {
                const articleCard = document.createElement('div');
                articleCard.className =
                    'border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 mb-5';
                articleCard.innerHTML = `
                        <div class="flex flex-col md:flex-row">
                            <div class="w-full md:w-1/3 h-48">
                                <img src="${article.image}" alt="Article image" class="w-full h-full object-cover">
                            </div>
                            <div class="w-full md:w-2/3 p-4">
                                <h3 class="font-semibold mb-2">${article.title}</h3>
                                <p class="text-sm text-gray-600 mb-4">${article.excerpt}</p>
                                <a href="#" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">Baca Artikel</a>
                            </div>
                        </div>
                    `;
                blogContent.appendChild(articleCard);
            });
        } else {
            // Populate hospital content
            const rumahSakitContent = document.getElementById('rumahSakitContent');
            rumahSakitContent.innerHTML = '';

            kondisi.hospitals.forEach(hospital => {
                const hospitalCard = document.createElement('div');
                hospitalCard.className =
                    'border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300';
                hospitalCard.innerHTML = `
                        <div class="flex flex-col md:flex-row">
                            <div class="w-full md:w-1/3">
                                <img src="${hospital.image}" alt="Hospital image" class="w-full h-full object-cover">
                            </div>
                            <div class="w-full md:w-2/3 p-4">
                                <h3 class="font-semibold mb-1">${hospital.name}</h3>
                                <p class="text-sm text-gray-600 mb-1">${hospital.address}</p>
                                <p class="text-sm text-blue-500 mb-3">Jarak: ${hospital.distance}</p>
                                <a href="#" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">Lihat Detail</a>
                            </div>
                        </div>
                    `;
                rumahSakitContent.appendChild(hospitalCard);
            });
        }
    }

    // Initialize with default content
    document.addEventListener('DOMContentLoaded', function() {
        updateContent();
    });
    switchTab(currentTab); // Set the default tab to 'blog'
</script>
