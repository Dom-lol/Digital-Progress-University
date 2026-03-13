/**
 * Data object containing information for each faculty
 */
const facultyData = {
    'it': {
        engTitle: 'Faculty of Science and Technology',
        khTitle: 'មហាវិទ្យាល័យវិទ្យាសាស្រ្តនិងបច្ចេកវិទ្យា',
        bg: 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1200',
        programs: [
            'បរិញ្ញាបត្ររងបច្ចេកវិទ្យាព័ត៌មាន',
            'បរិញ្ញាបត្ររងវិទ្យាសាស្រ្តទិន្នន័យនិងវិស្វកម្មបញ្ញាសិប្បនិម្មិត',
            'បរិញ្ញាបត្ររងរចនាប្រព័ន្ធផ្សព្វផ្សាយឌីជីថល',
            'បរិញ្ញាបត្រវិទ្យាសាស្រ្ត ជំនាញបច្ចេកវិទ្យាព័ត៌មាន',
            'បរិញ្ញាបត្រវិទ្យាសាស្រ្ត ជំនាញវិទ្យាសាស្រ្តទិន្នន័យនិងវិស្វកម្មបញ្ញាសិប្បនិម្មិត',
            'បរិញ្ញាបត្រវិទ្យាសាស្រ្ត ជំនាញរចនាប្រព័ន្ធផ្សព្វផ្សាយឌីជីថល',
            'បរិញ្ញាបត្រជាន់ខ្ពស់វិទ្យាសាស្រ្ត ជំនាញបច្ចេកវិទ្យាព័ត៌មាន',
            'មជ្ឈមណ្ឌលបច្ចេកវិទ្យាព័ត៌មាន'
        ]
    },
    'ba': {
        engTitle: 'Faculty of Digital Business',
        khTitle: 'មហាវិទ្យាល័យធុរកិច្ចឌីជីថល',
        bg: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1200',
        programs: [
            'បរិញ្ញាបត្ររងផ្នែកទីផ្សារឌីជីថល',
            'បរិញ្ញាបត្រផ្នែកគ្រប់គ្រងពាណិជ្ជកម្ម',
            'បរិញ្ញាបត្រផ្នែកពាណិជ្ជកម្មអេឡិចត្រូនិច',
            'បរិញ្ញាបត្រផ្នែកហិរញ្ញវត្ថុឌីជីថល'
        ]
    },
    'en': {
        engTitle: 'Faculty of Engineering',
        khTitle: 'មហាវិទ្យាល័យវិស្វកម្ម',
        bg: 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=1200',
        programs: [
            'បរិញ្ញាបត្រវិស្វកម្មអគ្គិសនី',
            'បរិញ្ញាបត្រវិស្វកម្មមេកានិក',
            'ជំនាញរ៉ូបូត និងស្វ័យប្រវត្តិកម្ម'
        ]
    },
    'md': {
        engTitle: 'Faculty of Digital Media & Design',
        khTitle: 'មហាវិទ្យាល័យរចនាប្រព័ន្ធផ្សព្វផ្សាយឌីជីថល',
        bg: 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=1200',
        programs: [
            'បរិញ្ញាបត្ររងរចនាប្រព័ន្ធផ្សព្វផ្សាយ',
            'បរិញ្ញាបត្រ UI/UX Design',
            'ជំនាញមហន្តរាយឌីជីថល'
        ]
    }
};

/**
 * Function to update the DOM based on URL ID
 */
function initFacultyPage() {
    // Get ID from URL: pages/faculty-detail.html?id=it
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    // Default to 'it' if ID is missing or not found
    const currentFaculty = facultyData[id] || facultyData['it'];

    // Select elements and update content
    const engTitleElem = document.getElementById('eng-title');
    const khTitleElem = document.getElementById('kh-title');
    const bgElem = document.getElementById('faculty-bg');
    const container = document.getElementById('programs-container');

    if (engTitleElem) engTitleElem.innerText = currentFaculty.engTitle;
    if (khTitleElem) khTitleElem.innerText = currentFaculty.khTitle;
    if (bgElem) bgElem.src = currentFaculty.bg;

    // Build the programs list
    if (container) {
        container.innerHTML = currentFaculty.programs.map(item => `
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:border-[#1e5f8a] transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full group-hover:scale-150 transition-transform"></div>
                    <h5 class="font-bold text-gray-800 text-lg">${item}</h5>
                </div>
            </div>
        `).join('');
    }
}

// Run the function when the page is loaded
document.addEventListener('DOMContentLoaded', initFacultyPage);