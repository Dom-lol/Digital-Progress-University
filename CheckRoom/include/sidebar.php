<?php
// ទាញយកឈ្មោះ File បច្ចុប្បន្ន (ឧទាហរណ៍៖ dashboard.php)
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="w-72 bg-white border-r border-slate-100 flex flex-col p-6 hidden lg:flex sticky top-0 h-screen">
   
    
    <nav class="flex-1 space-y-3">
       

        <?php $isActive = ($current_page == 'dashboard.php'); ?>
        <a href="/views/dashboard.php" 
           class="flex items-center gap-4 px-5 py-4 transition-all duration-300 rounded-2xl text-sm
           <?php echo $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-black' : 'text-slate-400 hover:text-blue-600 hover:bg-blue-50/50 font-bold'; ?>">
            
            <span class="italic uppercase tracking-wide">Dashboard</span>
        </a>

       <?php $is_building_page = (strpos($_SERVER['REQUEST_URI'], 'checkroom') !== false); ?>

        <a href="./views/checkroom/buildings.php" 
        class="flex items-center gap-4 px-5 py-4 transition-all duration-300 rounded-2xl text-sm
        <?php echo $is_building_page ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/30 font-black' : 'text-slate-400 hover:text-blue-600 hover:bg-blue-50/50 font-bold'; ?> group">
            
            
            
            <div class="flex flex-col">
                <span class="uppercase tracking-wide leading-none">អគារ និងបន្ទប់</span>
                <?php if($is_building_page): ?>
                    <span class="text-[9px] opacity-70 font-medium mt-1 uppercase tracking-[0.1em]">កំពុងមើលបញ្ជី</span>
                <?php endif; ?>
            </div>
        </a>
    </nav>

    <div class="pt-6 border-t border-slate-50">
        <a href="/UNIVERSITY/logout.php" class="flex items-center gap-4 px-5 py-4 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all font-bold text-sm italic group">
            <i class="fas fa-sign-out-alt group-hover:translate-x-1 transition-transform"></i> ចាកចេញ
        </a>
    </div>
</aside>