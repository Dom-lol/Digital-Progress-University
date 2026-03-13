<?php 
    // ១. បង្ខំឱ្យប្រើ Path ត្រឹមត្រូវការពារការវង្វេងហ្វាល
    require_once __DIR__ . '/config/db.php'; 
    include __DIR__ . '/include/header.php'; 
    include __DIR__ . '/include/sidebar.php'; 

    // ២. ទាញទិន្នន័យសង្ខេបពី Database (ជាមួយ Error Handling)
    
    // ចំនួនអគារសរុប
    $resB = mysqli_query($conn, "SELECT COUNT(*) as total FROM buildings");
    $countB = ($resB) ? mysqli_fetch_assoc($resB)['total'] : 0;

    // ចំនួនបន្ទប់សរុប
    $resR = mysqli_query($conn, "SELECT COUNT(*) as total FROM rooms");
    $countR = ($resR) ? mysqli_fetch_assoc($resR)['total'] : 0;

    // ចំនួនវត្តមាននៅថ្ងៃនេះ (ឧទាហរណ៍៖ រាប់ចំនួនបន្ទប់ដែលបានស្រង់វត្តមានរួច)
    $today = date('Y-m-d');
    $resA = mysqli_query($conn, "SELECT COUNT(*) as total FROM attendance WHERE attendance_date = '$today'");
    $countA = ($resA) ? mysqli_fetch_assoc($resA)['total'] : 0;
?>

<div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-10">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase italic">ផ្ទាំងគ្រប់គ្រងទូទៅ</h2>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">Dashboard Overview</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-blue-50 px-4 py-2 rounded-2xl border border-blue-100 shadow-sm text-right hidden sm:block">
                <span class="block text-[10px] font-black text-blue-400 uppercase tracking-widest italic">កាលបរិច្ឆេទ</span>
                <span class="text-sm font-black text-blue-700"><?php echo date('d F, Y'); ?></span>
            </div>
            <button class="w-11 h-11 border border-slate-200 rounded-2xl flex items-center justify-center text-slate-500 hover:bg-white hover:text-blue-600 transition-all shadow-sm">
                <i class="fas fa-bell"></i>
            </button>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto bg-[#F8FAFC] p-8 space-y-8 custom-scrollbar">
        
       <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    
    <a href="views/checkroom/buildings.php" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 flex items-center group hover:-translate-y-1 transition-all cursor-pointer">
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[1.5rem] flex items-center justify-center text-2xl mr-5 shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
            <i class="fas fa-building"></i>
        </div>
        <div>
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">អគារសរុប</p>
            <h3 class="text-3xl font-black text-slate-800 leading-none mt-1">
                <?php echo number_format($countB); ?> 
                <span class="text-xs font-bold text-slate-400 ml-1 italic opacity-60">អគារ</span>
            </h3>
        </div>
    </a>

    <a href="views/checkroom/index.php" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 flex items-center group hover:-translate-y-1 transition-all cursor-pointer">
        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-[1.5rem] flex items-center justify-center text-2xl mr-5 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
            <i class="fas fa-door-open"></i>
        </div>
        <div>
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">បន្ទប់សរុប</p>
            <h3 class="text-3xl font-black text-slate-800 leading-none mt-1">
                <?php echo number_format($countR); ?> 
                <span class="text-xs font-bold text-slate-400 ml-1 italic opacity-60">បន្ទប់</span>
            </h3>
        </div>
    </a>

    <a href="views/attendance/index.php" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 flex items-center group hover:-translate-y-1 transition-all cursor-pointer">
        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-[1.5rem] flex items-center justify-center text-2xl mr-5 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
            <i class="fas fa-user-check"></i>
        </div>
        <div>
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">វត្តមានថ្ងៃនេះ</p>
            <h3 class="text-3xl font-black text-slate-800 leading-none mt-1">
                <?php echo number_format($countA); ?> 
                <span class="text-xs font-bold text-slate-400 ml-1 italic opacity-60">នាក់</span>
            </h3>
        </div>
    </a>
</div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50">
            <div class="flex items-center mb-8">
                <div class="w-2 h-8 bg-blue-600 rounded-full mr-4 shadow-lg shadow-blue-500/30"></div>
                <h4 class="text-xl font-black text-slate-800 tracking-tight uppercase italic">សកម្មភាពរហ័ស <span class="text-blue-600">(Quick Actions)</span></h4>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="views/attendance/index.php" class="p-8 bg-slate-50 border border-slate-100 rounded-[2rem] hover:bg-blue-600 hover:text-white hover:shadow-2xl hover:shadow-blue-500/30 transition-all group relative overflow-hidden">
                    <i class="fas fa-clipboard-list text-4xl text-blue-500 mb-4 group-hover:text-white/80 group-hover:scale-110 transition-transform"></i>
                    <span class="block font-black text-sm uppercase tracking-wide">ស្រង់វត្តមាន</span>
                    <span class="text-[10px] text-slate-400 font-bold group-hover:text-blue-100 transition-colors uppercase">Attendance</span>
                </a>
                
                <a href="views/checkroom/manage.php" class="p-8 bg-slate-50 border border-slate-100 rounded-[2rem] hover:bg-emerald-600 hover:text-white hover:shadow-2xl hover:shadow-emerald-500/30 transition-all group relative overflow-hidden">
                    <i class="fas fa-file-excel text-4xl text-emerald-500 mb-4 group-hover:text-white/80 group-hover:scale-110 transition-transform"></i>
                    <span class="block font-black text-sm uppercase tracking-wide">បញ្ចូល EXCEL</span>
                    <span class="text-[10px] text-slate-400 font-bold group-hover:text-emerald-100 transition-colors uppercase">Bulk Upload</span>
                </a>

                <a href="views/checkroom/index.php" class="p-8 bg-white border border-slate-200 rounded-[2rem] hover:bg-indigo-600 hover:text-white hover:border-indigo-500 hover:shadow-2xl hover:shadow-indigo-500/30 transition-all group text-center">
                    <i class="fas fa-plus-circle text-4xl text-indigo-500 mb-4 group-hover:text-white/80 group-hover:scale-110 transition-transform block"></i>
                    <span class="block font-black text-sm uppercase italic">បន្ថែមអគារ</span>
                </a>

                <a href="#" class="p-8 bg-white border border-slate-200 rounded-[2rem] hover:bg-orange-600 hover:text-white hover:border-orange-500 hover:shadow-2xl hover:shadow-orange-500/30 transition-all group text-center">
                    <i class="fas fa-print text-4xl text-orange-500 mb-4 group-hover:text-white/80 group-hover:scale-110 transition-transform block"></i>
                    <span class="block font-black text-sm uppercase italic">របាយការណ៍</span>
                </a>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/include/footer.php'; ?>