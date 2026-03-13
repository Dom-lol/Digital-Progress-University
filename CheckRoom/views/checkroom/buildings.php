<?php 
    require_once __DIR__ . '/../../config/db.php'; 
    include __DIR__ . '/../../include/header.php'; 
    include __DIR__ . '/../../include/sidebar.php'; 

    // ១. ទាញទិន្នន័យបន្ទប់ទាំងអស់ជាគោល ដើម្បីឱ្យ List View បង្ហាញ Detail បាន
    $query = "SELECT r.*, b.building_name, b.totalfloor as b_total 
              FROM rooms r 
              JOIN buildings b ON r.building_id = b.id 
              ORDER BY b.building_name ASC, r.floor_number ASC, r.room_name ASC";
    $result = mysqli_query($conn, $query);

    // ២. ទាញបញ្ជីអគារសម្រាប់ Select Box
    $b_list = mysqli_query($conn, "SELECT id, building_name, totalfloor FROM buildings ORDER BY building_name ASC");
    $buildings_data = [];
    while($b = mysqli_fetch_assoc($b_list)) { $buildings_data[] = $b; }

    // ៣. បម្លែងបន្ទប់ទាំងអស់ជា JSON សម្រាប់ JS Filter
    $all_rooms_json = [];
    mysqli_data_seek($result, 0);
    while($rq = mysqli_fetch_assoc($result)) { $all_rooms_json[] = $rq; }
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F8FAFC]">
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-50">
        <div>
            <h2 class="text-2xl font-[900] text-slate-800 tracking-tight uppercase italic leading-none">គ្រប់គ្រងអគារ និងបន្ទប់</h2>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Building & Room Management</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="toggleModal('modalImport')" class="flex items-center gap-2 bg-emerald-50 text-emerald-600 px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100 shadow-sm">
                <i class="fas fa-file-import text-sm"></i> Import
            </button>
            <button onclick="toggleModal('modalBuilding')" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-black text-xs uppercase shadow-lg shadow-blue-500/20 hover:scale-105 transition-all">
                <i class="fas fa-plus-circle mr-2"></i> បន្ថែមអគារ
            </button>
            <button onclick="toggleModal('modalRoom')" class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-black text-xs uppercase shadow-lg shadow-emerald-500/20 hover:scale-105 transition-all">
                <i class="fas fa-door-open mr-2"></i> បន្ថែមបន្ទប់
            </button>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-8 lg:p-10 custom-scrollbar">
        <div class="flex flex-wrap items-center gap-4 mb-10">
            <div class="flex-1 min-w-[200px] relative">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="smartSearch" onkeyup="smartFilter()" placeholder="ស្វែងរកលេខបន្ទប់ ឬអគារ..." 
                       class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-[1.5rem] shadow-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium outline-none">
            </div>

            <div class="flex gap-2">
                <select id="filterBuilding" onchange="updateFloorFilter()" class="px-4 py-4 bg-white border border-slate-200 rounded-2xl font-bold text-xs uppercase text-slate-600 outline-none focus:border-blue-500 shadow-sm cursor-pointer">
                    <option value="">អគារទាំងអស់</option>
                    <?php foreach($buildings_data as $b): ?>
                        <option value="<?= $b['id'] ?>" data-total="<?= $b['totalfloor'] ?>"><?= $b['building_name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="filterFloor" onchange="updateRoomFilter()" class="px-4 py-4 bg-white border border-slate-200 rounded-2xl font-bold text-xs uppercase text-slate-600 outline-none focus:border-blue-500 shadow-sm cursor-pointer">
                    <option value="">ជាន់ទាំងអស់</option>
                </select>

                <select id="filterRoom" onchange="smartFilter()" class="px-4 py-4 bg-white border border-slate-200 rounded-2xl font-bold text-xs uppercase text-slate-600 outline-none focus:border-blue-500 shadow-sm cursor-pointer">
                    <option value="">បន្ទប់ទាំងអស់</option>
                </select>
                
                <button onclick="resetFilters()" class="px-4 py-4 bg-slate-100 text-slate-500 rounded-2xl hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200">
                <button onclick="switchView('grid')" id="gridBtn" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase transition-all bg-blue-600 text-white shadow-md">Grid</button>
                <button onclick="switchView('list')" id="listBtn" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase transition-all text-slate-400">List</button>
            </div>
        </div>

        <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
                $b_query = "SELECT b.*, COUNT(r.id) as total_rooms FROM buildings b LEFT JOIN rooms r ON b.id = r.building_id GROUP BY b.id ORDER BY b.id DESC";
                $b_result = mysqli_query($conn, $b_query);
                while($row = mysqli_fetch_assoc($b_result)): 
            ?>
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group relative overflow-hidden card-item" data-type="building" data-building-id="<?= $row['id'] ?>">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-bl-full -mr-16 -mt-16 transition-all group-hover:bg-blue-600/10"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-building"></i>
                    </div>
                    <span class="text-[10px] font-black bg-blue-50 text-blue-600 px-4 py-2 rounded-xl uppercase"><?php echo $row['total_rooms']; ?> Rooms</span>
                </div>
                <div class="mt-8 relative z-10">
                    <h3 class="text-xl font-black text-slate-800 uppercase italic name-target"><?php echo $row['building_name']; ?></h3>
                    <p class="text-xs font-bold text-slate-400 uppercase mt-2">Floors: <span class="text-slate-800"><?php echo $row['totalfloor'] ?? 0; ?></span></p>
                </div>
                <div class="mt-8 pt-8 border-t border-slate-50 flex gap-3 relative z-10">
                    <button class="flex-1 py-3.5 bg-slate-50 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-blue-600 hover:text-white transition-all">Details</button>
                    <button onclick="confirmDelete('building', <?= $row['id'] ?>)" class="w-12 h-12 bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-600 hover:text-white transition-all"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <div id="listView" class="hidden bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">អគារ</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">ជាន់</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">លេខបន្ទប់</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-slate-50">
                    <?php foreach($all_rooms_json as $row): ?>
                    <tr class="hover:bg-blue-50/30 transition-colors card-item" 
                        data-type="room"
                        data-building-id="<?= $row['building_id']; ?>" 
                        data-floor="<?= $row['floor_number']; ?>"
                        data-room="<?= $row['room_name']; ?>">
                        
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black bg-blue-50 text-blue-600 px-3 py-1 rounded-lg uppercase">
                                <?= $row['building_name']; ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-500">ជាន់ទី <?= $row['floor_number']; ?></td>
                        <td class="px-8 py-5 font-black text-slate-800 italic uppercase name-target"><?= $row['room_name']; ?></td>
                        <td class="px-8 py-5 text-right">
                             <button onclick="editRoom(<?= htmlspecialchars(json_encode($row)) ?>)" class="text-slate-400 hover:text-blue-600 mr-4"><i class="fas fa-edit"></i></button>
                             <button onclick="confirmDelete('room', <?= $row['id'] ?>)" class="text-slate-400 hover:text-rose-500"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<div id="modalImport" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl p-8 max-h-[90vh] flex flex-col transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-800 uppercase italic leading-none">នាំចូលទិន្នន័យ (Import)</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">បោះទិន្នន័យពី Excel/CSV ចូលទៅក្នុងប្រព័ន្ធ</p>
            </div>
            <button onclick="toggleModal('modalImport')" class="text-slate-300 hover:text-rose-500 transition-colors">
                <i class="fas fa-times-circle text-3xl"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 overflow-hidden">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <h4 class="text-xs font-black text-slate-700 uppercase mb-4 flex items-center gap-2"><i class="fas fa-info-circle text-blue-500"></i> ការណែនាំ</h4>
                    <ul class="text-[11px] text-slate-500 space-y-3 font-medium">
                        <li class="flex gap-2"><i class="fas fa-check-circle text-emerald-500 mt-0.5"></i> ប្រើប្រាស់ Template CSV</li>
                        <li class="flex gap-2"><i class="fas fa-check-circle text-emerald-500 mt-0.5"></i> កុំផ្លាស់ប្តូរ Header</li>
                    </ul>
                    <a href="../../actions/template_download.php" class="w-full mt-6 flex items-center justify-center gap-2 bg-white text-blue-600 border-2 border-blue-100 py-3 rounded-2xl font-black text-[10px] uppercase hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="fas fa-download"></i> Template
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 flex flex-col min-h-0">
                <div id="dropZone" class="relative group border-4 border-dashed border-slate-100 rounded-[2rem] p-8 text-center hover:border-blue-200 hover:bg-blue-50/30 transition-all cursor-pointer">
                    <input type="file" id="csvFileInput" accept=".csv" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewCSV()">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <p class="text-sm font-black text-slate-700 uppercase">រើស File ឬ ទាញដាក់ទីនេះ</p>
                </div>

                <div id="previewContainer" class="mt-6 flex-1 overflow-hidden flex flex-col hidden">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">ទិន្នន័យរកឃើញ៖</span>
                        <span id="rowCountLabel" class="bg-blue-600 text-white text-[9px] font-black px-2 py-0.5 rounded-md">0 ជួរ</span>
                    </div>
                    <div class="flex-1 overflow-y-auto rounded-2xl border border-slate-100 bg-slate-50">
                        <table class="w-full text-[11px] text-left">
                            <thead class="sticky top-0 bg-white border-b border-slate-100">
                                <tr>
                                    <th class="p-3 font-black uppercase text-slate-400">Building</th>
                                    <th class="p-3 font-black uppercase text-slate-400">T.Floor</th>
                                    <th class="p-3 font-black uppercase text-slate-400 text-center">Floor</th>
                                    <th class="p-3 font-black uppercase text-slate-400 text-right">Room</th>
                                </tr>
                            </thead>
                            <tbody id="previewTableBody" class="divide-y divide-slate-100 font-bold text-slate-600"></tbody>
                        </table>
                    </div>
                    <form action="../../actions/bulk_import.php" method="POST" id="importForm" class="mt-6">
                        <input type="hidden" name="csv_data" id="csvDataInput">
                        <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg hover:bg-emerald-700 transition-all">នាំចូលទិន្នន័យ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalBuilding" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-slate-800 uppercase italic">បន្ថែមអគារថ្មី</h3>
            <button onclick="toggleModal('modalBuilding')" class="text-slate-300 hover:text-rose-500"><i class="fas fa-times-circle text-2xl"></i></button>
        </div>
        <form action="../../actions/building_controller.php" method="POST" class="space-y-5">
            <input type="hidden" name="action" value="add">
            <div>
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">ឈ្មោះអគារ</label>
                <input type="text" name="building_name" required placeholder="ឧទាហរណ៍៖ អគារ A" 
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-bold text-slate-700">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">ចំនួនជាន់សរុប</label>
                <input type="number" name="totalfloor" required placeholder="ឧទាហរណ៍៖ 5" 
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-bold text-slate-700">
            </div>
            <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all">រក្សាទុកអគារ</button>
        </form>
    </div>
</div>

<div id="modalEditBuilding" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl p-8 transform transition-all">
        <h3 class="text-xl font-black text-slate-800 uppercase italic mb-6">កែសម្រួលអគារ</h3>
        
        <form action="../../actions/building_controller.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="building_id" id="edit_b_id">
            
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase ml-2">ឈ្មោះអគារ</label>
                    <input type="text" name="building_name" id="edit_b_name" required 
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase ml-2">ចំនួនជាន់សរុប</label>
                    <input type="number" name="total_floors" id="edit_b_floors" required
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold">
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="button" onclick="toggleModal('modalEditBuilding')" class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black uppercase tracking-widest hover:bg-slate-200 transition-all">បោះបង់</button>
                <button type="submit" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all">រក្សាទុក</button>
            </div>
        </form>
    </div>
</div>

<div id="modalRoom" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 id="roomModalTitle" class="text-xl font-black text-slate-800 uppercase italic">បន្ថែមបន្ទប់ថ្មី</h3>
            <button onclick="toggleModal('modalRoom')" class="text-slate-300 hover:text-rose-500"><i class="fas fa-times-circle text-2xl"></i></button>
        </div>
        <form action="../../actions/room_controller.php" method="POST" class="space-y-5">
            <input type="hidden" name="action" id="roomAction" value="add">
            <input type="hidden" name="room_id" id="editRoomId">
            
            <div>
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">ជ្រើសរើសអគារ</label>
                <select name="building_id" id="select_building" required onchange="updateFloorOptions()" 
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-bold text-slate-700 appearance-none">
                    <option value="">-- រើសអគារ --</option>
                    <?php foreach($buildings_data as $b): ?>
                        <option value="<?= $b['id'] ?>" data-floors="<?= $b['totalfloor'] ?>"><?= $b['building_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">លេខបន្ទប់</label>
                    <input type="text" name="room_name" id="modalRoomName" required placeholder="101" 
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-bold text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">ជ្រើសរើសជាន់</label>
                    <select name="floor_number" id="select_floor" required 
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-bold text-slate-700 appearance-none">
                        <option value="">-- រើសជាន់ --</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all">
                រក្សាទុកទិន្នន័យ
            </button>
        </form>
    </div>
</div>

<script>
    // ១. ទិន្នន័យបន្ទប់ពី PHP សម្រាប់ប្រើក្នុង Filter
    const allRooms = <?php echo json_encode($all_rooms_json); ?>;

    // ២. មុខងារប្តូរ View (Grid / List)
    function switchView(view) {
        const grid = document.getElementById('gridView');
        const list = document.getElementById('listView');
        const gBtn = document.getElementById('gridBtn');
        const lBtn = document.getElementById('listBtn');
        if(view === 'grid') {
            grid.classList.remove('hidden'); list.classList.add('hidden');
            gBtn.className = "px-6 py-2.5 rounded-xl text-xs font-black uppercase bg-blue-600 text-white shadow-md transition-all";
            lBtn.className = "px-6 py-2.5 rounded-xl text-xs font-black uppercase text-slate-400 transition-all";
        } else {
            grid.classList.add('hidden'); list.classList.remove('hidden');
            lBtn.className = "px-6 py-2.5 rounded-xl text-xs font-black uppercase bg-blue-600 text-white shadow-md transition-all";
            gBtn.className = "px-6 py-2.5 rounded-xl text-xs font-black uppercase text-slate-400 transition-all";
        }
    }

    // ៣. Smart Filter Logic (Search & Select)
    function smartFilter() {
        const b_id = document.getElementById('filterBuilding').value;
        const f_num = document.getElementById('filterFloor').value;
        const r_name = document.getElementById('filterRoom').value.toLowerCase();
        const searchVal = document.getElementById('smartSearch').value.toLowerCase();

        document.querySelectorAll('.card-item').forEach(el => {
            const rowBId = el.getAttribute('data-building-id');
            const rowF = el.getAttribute('data-floor');
            const rowR = (el.getAttribute('data-room') || "").toLowerCase();
            const text = el.innerText.toLowerCase();

            const matchB = b_id === "" || rowBId === b_id;
            const matchF = f_num === "" || rowF === f_num;
            const matchR = r_name === "" || rowR === r_name;
            const matchS = text.includes(searchVal);

            el.style.display = (matchB && matchF && matchR && matchS) ? "" : "none";
        });
    }

    // ៤. Update Dependent Filters (Building -> Floor -> Room)
    function updateFloorFilter() {
        const select = document.getElementById('filterBuilding');
        const total = select.options[select.selectedIndex].getAttribute('data-total');
        const floorSelect = document.getElementById('filterFloor');
        
        floorSelect.innerHTML = '<option value="">ជាន់ទាំងអស់</option>';
        if(total) {
            for(let i=1; i<=total; i++) floorSelect.innerHTML += `<option value="${i}">ជាន់ទី ${i}</option>`;
        }
        updateRoomFilter();
    }

    function updateRoomFilter() {
        const b_id = document.getElementById('filterBuilding').value;
        const f_num = document.getElementById('filterFloor').value;
        const roomSelect = document.getElementById('filterRoom');
        
        roomSelect.innerHTML = '<option value="">បន្ទប់ទាំងអស់</option>';
        allRooms.filter(r => (b_id==="" || r.building_id==b_id) && (f_num==="" || r.floor_number==f_num))
                .forEach(r => roomSelect.innerHTML += `<option value="${r.room_name}">${r.room_name}</option>`);
        smartFilter();
    }

    // ៥. Logic សម្រាប់ Modal (បើក/បិទ)
    function toggleModal(id) { 
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden'); 
        
        // បើបិទ Modal Import ត្រូវ Reset Preview ឱ្យស្អាតវិញ
        if (id === 'modalImport' && modal.classList.contains('hidden')) {
            document.getElementById('previewContainer').classList.add('hidden');
            document.getElementById('csvFileInput').value = '';
            document.getElementById('dropZone').querySelector('p').innerText = "រើស File ឬ ទាញដាក់ទីនេះ";
        }
    }

    // ៦. Preview CSV Logic (សម្រាប់ Modal Import ថ្មី)
    function previewCSV() {
        const fileInput = document.getElementById('csvFileInput');
        const container = document.getElementById('previewContainer');
        const tableBody = document.getElementById('previewTableBody');
        const rowCountLabel = document.getElementById('rowCountLabel');
        const csvDataInput = document.getElementById('csvDataInput');
        const dropZone = document.getElementById('dropZone');

        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const text = e.target.result;
                const rows = text.split('\n').filter(row => row.trim() !== '');
                
                let dataArray = [];
                let html = '';
                let count = 0;

                // ចាប់ផ្ដើមពីជួរទី ២ (Skip Header)
                for (let i = 1; i < rows.length; i++) {
                    const cols = rows[i].split(',').map(c => c.trim());
                    if (cols.length >= 4) {
                        dataArray.push(cols);
                        html += `
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="p-3 uppercase italic text-slate-700">${cols[0]}</td>
                                <td class="p-3 text-slate-400">${cols[1]}</td>
                                <td class="p-3 text-center text-blue-600">${cols[2]}</td>
                                <td class="p-3 text-right font-black italic text-slate-800">${cols[3]}</td>
                            </tr>
                        `;
                        count++;
                    }
                }

                // បោះទិន្នន័យចូល Input ដើម្បីផ្ញើទៅ PHP
                csvDataInput.value = JSON.stringify(dataArray);
                tableBody.innerHTML = html;
                rowCountLabel.innerText = count + ' ជួរ';
                
                // បង្ហាញ UI Preview
                container.classList.remove('hidden');
                dropZone.classList.add('py-4');
                dropZone.querySelector('p').innerText = "ប្តូរឯកសារថ្មី (" + file.name + ")";
            };
            reader.readAsText(file);
        }
    }

    // ៧. Edit Room Function
    function editRoom(data) {
        document.getElementById('roomModalTitle').innerText = "កែសម្រួលបន្ទប់";
        document.getElementById('roomAction').value = "edit";
        document.getElementById('editRoomId').value = data.id;
        document.getElementById('select_building').value = data.building_id;
        updateFloorOptions(); 
        document.getElementById('select_floor').value = data.floor_number;
        document.getElementById('modalRoomName').value = data.room_name;
        toggleModal('modalRoom');
    }

    // ៨. មុខងារ Update ជាន់ក្នុង Modal បន្ថែមបន្ទប់
    function updateFloorOptions() {
        const b = document.getElementById('select_building');
        const f = document.getElementById('select_floor');
        const total = b.options[b.selectedIndex].getAttribute('data-floors');
        f.innerHTML = '<option value="">-- រើសជាន់ --</option>';
        if(total) for(let i=1; i<=total; i++) f.innerHTML += `<option value="${i}">ជាន់ទី ${i}</option>`;
    }

    // ៩. Delete with SweetAlert2
    function confirmDelete(type, id) {
        Swal.fire({
            title: 'តើអ្នកប្រាកដទេ?',
            text: "ទិន្នន័យនេះនឹងត្រូវលុបចេញ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Okay',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../../actions/delete_controller.php?type=${type}&id=${id}`;
            }
        })
    }

    // ១០. Reset All Filters
    function resetFilters() {
        document.getElementById('filterBuilding').value = "";
        document.getElementById('filterFloor').innerHTML = '<option value="">ជាន់ទាំងអស់</option>';
        document.getElementById('filterRoom').innerHTML = '<option value="">បន្ទប់ទាំងអស់</option>';
        document.getElementById('smartSearch').value = "";
        smartFilter();
    }

    // ១១. បង្ហាញ Success/Error Alert បន្ទាប់ពី Redirect មកវិញ
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // ឆែកមើលការបន្ថែម ឬលុប (តាមរយៈ status ឬ deleted ឬ success)
        const status = urlParams.get('status') || urlParams.get('success') || (urlParams.has('deleted') ? 'deleted' : null);

        if (status) {
            let config = {
                timer: 2500,
                showConfirmButton: false,
                borderRadius: '2rem',
                customClass: {
                    popup: 'rounded-[2rem]'
                }
            };

            if (status === 'success' || status === 'added' || status === 'deleted') {
                config.icon = 'success';
                config.title = 'ប្រតិបត្តិការជោគជ័យ!';
                config.text = (status === 'deleted') ? 'ទិន្នន័យត្រូវបានលុបចេញពីប្រព័ន្ធ' : 'ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ';
            } else if (status === 'error') {
                config.icon = 'error';
                config.title = 'មានបញ្ហា!';
                config.text = urlParams.get('msg') || 'មិនអាចអនុវត្តប្រតិបត្តិការបានទេ';
                config.showConfirmButton = true;
                config.timer = null; // បើ error ទុកឱ្យ user ចុចបិទខ្លួនឯង
            }

            Swal.fire(config);

            // សម្អាត URL បន្ទាប់ពីបង្ហាញ Alert រួច ដើម្បីកុំឱ្យ Refresh ទៅវាលោតមកទៀត
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>