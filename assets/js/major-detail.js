document.addEventListener('DOMContentLoaded', () => {
    // ១. ទាញយក Parameters ពី URL (?faculty=it&major=it-gen)
    const urlParams = new URLSearchParams(window.location.search);
    const facultyId = urlParams.get('faculty');
    const majorId = urlParams.get('major');

    // ២. បញ្ជាក់ថាមានទិន្នន័យ facultyData ពី file faculty-data.js
    if (typeof facultyData !== 'undefined') {
        const faculty = facultyData[facultyId];
        
        if (faculty) {
            // បង្ហាញ Breadcrumb (ឈ្មោះមហាវិទ្យាល័យ)
            document.getElementById('faculty-breadcrumb').innerText = faculty.engTitle;
            
            // ស្វែងរក Major ដែលត្រូវគ្នា
            const major = faculty.programs.find(p => p.id === majorId);

            if (major) {
                // កំណត់ចំណងជើង និងព័ត៌មានទូទៅ
                document.getElementById('major-name').innerText = major.name;
                document.getElementById('major-kh').innerText = major.name;
                document.getElementById('info-duration').innerText = major.duration;
                document.getElementById('info-credits').innerText = major.credits;

                // បង្ហាញបញ្ជីមុខវិជ្ជា (Subjects)
                const subjectsContainer = document.getElementById('subjects-container');
                subjectsContainer.innerHTML = ''; 
                major.subjects.forEach((subject, index) => {
                    subjectsContainer.innerHTML += `
                        <div class="flex items-center gap-6 p-6 bg-white border border-gray-50 rounded-[24px] hover:border-yellow-400 hover:shadow-md transition-all group">
                            <div class="w-10 h-10 shrink-0 bg-blue-50 text-[#1e5f8a] font-black rounded-xl flex items-center justify-center group-hover:bg-yellow-400 group-hover:text-white transition-colors">
                                ${index + 1}
                            </div>
                            <span class="text-gray-700 font-bold text-lg">${subject}</span>
                        </div>
                    `;
                });

                // បង្ហាញព័ត៌មានទំនាក់ទំនង
                const contactContainer = document.getElementById('major-contact');
                const email = faculty.contact?.email || 'info@dpu.edu.kh';
                const phone = faculty.contact?.phone || '+855 12 345 678';
                const loc = faculty.contact?.location || 'Building A, Campus I';

                contactContainer.innerHTML = `
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#1e5f8a] group-hover:bg-[#1e5f8a] group-hover:text-white transition-all"><i class="fa-solid fa-envelope"></i></div>
                        <div><p class="text-[9px] uppercase font-black text-gray-400 tracking-widest">Email Address</p><p class="font-bold text-[#0a3d62] text-sm">${email}</p></div>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#1e5f8a] group-hover:bg-[#1e5f8a] group-hover:text-white transition-all"><i class="fa-solid fa-phone"></i></div>
                        <div><p class="text-[9px] uppercase font-black text-gray-400 tracking-widest">Phone Number</p><p class="font-bold text-[#0a3d62] text-sm">${phone}</p></div>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#1e5f8a] group-hover:bg-[#1e5f8a] group-hover:text-white transition-all"><i class="fa-solid fa-location-dot"></i></div>
                        <div><p class="text-[9px] uppercase font-black text-gray-400 tracking-widest">Location</p><p class="font-bold text-[#0a3d62] text-sm">${loc}</p></div>
                    </div>
                `;

            } else {
                showErrorMessage("Major Not Found");
            }
        } else {
            showErrorMessage("Faculty Not Found");
        }
    }
});

function showErrorMessage(msg) {
    document.body.innerHTML = `
        <div class="h-screen flex flex-col items-center justify-center bg-gray-50 p-10 text-center">
            <h1 class="text-6xl font-black text-gray-200 mb-4">404</h1>
            <p class="text-xl font-bold text-gray-500 mb-8 uppercase tracking-widest">${msg}</p>
            <a href="index.html" class="bg-[#1e5f8a] text-white px-8 py-3 rounded-xl font-bold hover:bg-yellow-400 hover:text-[#0a3d62] transition-all">Go Home</a>
        </div>
    `;
}