<?php
// ទាញយកឈ្មោះ File បច្ចុប្បន្ន (ឧទាហរណ៍៖ dashboard.php)
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="w-72 bg-white border-r border-slate-100 flex flex-col p-6 hidden lg:flex sticky top-0 h-screen">
    <div class="flex items-center gap-3 mb-10 px-2">
        <div class="w-12 h-12 bg-gradient-to-tr from-blue-700 to-blue-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-500/30 rotate-3">
            <i class="fas fa-university text-xl"></i>
        </div>
        <div>
            <h1 class="font-[900] text-slate-800 text-xl uppercase tracking-tighter leading-none">University</h1>
            <p class="text-[9px] text-slate-400 font-bold tracking-[0.2em] mt-1 uppercase">Management System</p>
        </div>
    </div>
    
    <nav class="flex-1 space-y-3">
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-4 px-5">មឺនុយមេ</p>

        <?php $isActive = ($current_page == 'dashboard.php'); ?>
        <a href="/UNIVERSITY/dashboard.php" 
           class="flex items-center gap-4 px-5 py-4 transition-all duration-300 rounded-2xl text-sm
           <?php echo $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-black' : 'text-slate-400 hover:text-blue-600 hover:bg-blue-50/50 font-bold'; ?>">
            <div class="w-8 h-8 flex items-center justify-center <?php echo $isActive ? 'bg-white/20' : 'group-hover:bg-white group-hover:shadow-sm'; ?> rounded-lg">
                <i class="fas fa-th-large text-base"></i>
            </div>
            <span class="italic uppercase tracking-wide">Dashboard</span>
        </a>

       <?php 
    // បង្កើត Logic ឱ្យច្បាស់លាស់សម្រាប់ទំព័រអគារ និងបន្ទប់
    $is_building_page = (strpos($_SERVER['REQUEST_URI'], 'checkroom') !== false);
?>

<a href="../../views/checkroom/buildings.php" 
   class="flex items-center gap-4 px-5 py-4 transition-all duration-300 rounded-2xl text-sm
   <?php echo $is_building_page ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/30 font-black' : 'text-slate-400 hover:text-blue-600 hover:bg-blue-50/50 font-bold'; ?> group">
    
    <div class="w-9 h-9 flex items-center justify-center transition-all duration-300 
        <?php echo $is_building_page ? 'bg-white/20 rotate-6' : 'bg-slate-50 group-hover:bg-white group-hover:shadow-md group-hover:rotate-6'; ?> rounded-xl">
        <i class="fas fa-building text-base <?php echo $is_building_page ? 'text-white' : 'text-slate-400 group-hover:text-blue-600'; ?>"></i>
    </div>
    
    <div class="flex flex-col">
        <span class="uppercase tracking-wide leading-none">អគារ និងបន្ទប់</span>
        <?php if($is_building_page): ?>
            <span class="text-[9px] opacity-70 font-medium mt-1 uppercase tracking-[0.1em]">កំពុងមើលបញ្ជី</span>
        <?php endif; ?>
    </div>
</a>

        <?php $isActive = (strpos($_SERVER['REQUEST_URI'], 'attendance') !== false); ?>
        <a href="/UNIVERSITY/views/attendance/index.php" 
           class="flex items-center gap-4 px-5 py-4 transition-all duration-300 rounded-2xl text-sm
           <?php echo $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-black' : 'text-slate-400 hover:text-blue-600 hover:bg-blue-50/50 font-bold'; ?>">
            <div class="w-8 h-8 flex items-center justify-center <?php echo $isActive ? 'bg-white/20' : 'group-hover:bg-white group-hover:shadow-sm'; ?> rounded-lg">
                <i class="fas fa-user-check text-base"></i>
            </div>
            <span class="italic uppercase tracking-wide">វត្តមាន</span>
        </a>
    </nav>

    <div class="pt-6 border-t border-slate-50">
        <a href="/UNIVERSITY/logout.php" class="flex items-center gap-4 px-5 py-4 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all font-bold text-sm italic group">
            <i class="fas fa-sign-out-alt group-hover:translate-x-1 transition-transform"></i> ចាកចេញ
        </a>
    </div>
</aside>