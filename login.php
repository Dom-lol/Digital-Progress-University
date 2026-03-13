<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Academic Portal | DPU</title>
    <style>
        body { font-family: 'Inter', 'Kantumruy Pro', sans-serif; }
        .hero-bg {
            background: linear-gradient(135deg, rgba(10, 61, 98, 0.9) 0%, rgba(30, 95, 138, 0.7) 100%), 
                        url('https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2000');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="hero-bg min-h-screen flex items-center justify-center px-6 py-10">

    <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-16">
        
        <div class="w-full lg:w-1/2 text-white space-y-8 flex flex-col items-center lg:items-start text-center lg:text-left">
            <div class="flex flex-col md:flex-row items-center gap-4">
                <a href="/index.html" class="shrink-0 transition-transform hover:rotate-3">
                    <img class="w-[80px] md:w-[120px]" src="./assets/img/favicon.ico" alt="DPU Logo">
                </a>
                <div class="text-white">
                    <h1 class="text-[20px] md:text-[24px] font-bold leading-tight">សាកលវិទ្យាល័យ វឌ្ឍនភាពឌីជីថល</h1>
                    <p class="text-[16px] md:text-[18px] opacity-90 uppercase tracking-wide">Digital Progress University</p>
                </div>
            </div>

            <h2 class="text-5xl lg:text-7xl font-extrabold leading-[1.1] tracking-tighter">
                Manage Your <br> Academic <span class="text-yellow-400 italic">Success.</span>
            </h2>

            <p class="text-blue-50 text-lg opacity-80 max-w-lg leading-relaxed font-medium">
                សូមស្វាគមន៍មកកាន់ប្រព័ន្ធគ្រប់គ្រងការសិក្សាឌីជីថល។ ចូលប្រើប្រាស់ដើម្បីពិនិត្យវត្តមាន ពិន្ទុ និងធនធានសិក្សាផ្សេងៗក្នុងពេលតែមួយ។
            </p>

            <div class="text-center lg:text-left">
                <a href="index.html" class="inline-flex items-center gap-2 text-white/50 hover:text-white text-[11px] font-bold transition-all opacity-90 uppercase tracking-wide group/link">
                    <span class="group-hover/link:-translate-x-1 transition-transform">←</span> Back to Official Website
                </a>
            </div>
        </div>

        <div class="w-full max-w-[480px]">
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.3)] p-10 lg:p-14 border border-gray-100/50 relative overflow-hidden">
                
                <div class="flex bg-gray-100/50 p-1.5 rounded-2xl mb-10 border border-gray-200/30">
                    <button id="studentTab" onclick="switchRole('student')" 
                        class="flex-1 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-[#0a3d62] text-white shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-user-graduate text-xs"></i> Student
                    </button>
                    <button id="lecturerTab" onclick="switchRole('lecturer')" 
                        class="flex-1 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-gray-400 hover:text-gray-600 flex items-center justify-center gap-2">
                        <i class="fas fa-university text-xs"></i> Lecturer
                    </button>
                </div>

                <div class="text-center mb-8">
                    <h3 id="formTitle" class="text-2xl font-black text-slate-800 tracking-tight italic">Student Access</h3>
                    <p id="formDesc" class="text-gray-400 text-sm mt-1 font-medium italic opacity-80">Enter your ID to access the student portal</p>
                </div>

                <form action="auth/login_process.php" method="POST" class="space-y-6">
                    <input type="hidden" name="role" id="roleInput" value="student">

                    <div class="space-y-2">
                        <label id="idLabel" class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 text-left block">Student ID</label>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 opacity-30 group-focus-within:opacity-100 group-focus-within:text-blue-600 transition-all">
                                <i class="far fa-user"></i>
                            </span>
                            <input type="text" name="username" id="usernameField" placeholder="e.g. B20230123" required
                                class="w-full pl-12 pr-6 py-4 bg-white border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 rounded-2xl outline-none transition-all font-medium text-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Password</label>
                            <button type="button" onclick="toggleModal(true)" class="text-[11px] font-bold text-blue-600 hover:underline">Forgot password?</button>
                        </div>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 opacity-30 group-focus-within:opacity-100 group-focus-within:text-blue-600 transition-all">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full pl-12 pr-6 py-4 bg-white border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 rounded-2xl outline-none transition-all font-medium">
                        </div>
                    </div>

                    <button type="submit" id="loginBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-2xl font-black text-sm shadow-xl shadow-blue-500/30 flex items-center justify-center gap-3 transition-all transform active:scale-[0.98]">
                        Login <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </form>

               <div class="mt-10 pt-8 border-t border-gray-50 flex items-center justify-center gap-4">
                    <span class="text-sm text-gray-400 font-medium italic">First time here?</span>
                    <a href="/pages/activate.html" class="text-sm font-black text-blue-600 hover:underline decoration-2 underline-offset-4 transition-all">Activate Account</a>
                </div>
            </div>
        </div>
    </div>

    <div id="forgotModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl transform transition-all">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 italic uppercase">Reset Password</h3>
                <p class="text-gray-400 text-sm mt-1">Enter your registered email to receive instructions.</p>
            </div>
            <form action="auth/reset_request.php" method="POST" class="space-y-4">
                <input type="email" name="email" placeholder="Enter your email" required
                    class="w-full px-6 py-4 bg-gray-50 border border-gray-200 focus:border-blue-500 rounded-2xl outline-none transition-all">
                <button type="submit" class="w-full bg-slate-800 text-white py-4 rounded-2xl font-bold hover:bg-black transition-all">Send Link</button>
                <button type="button" onclick="toggleModal(false)" class="w-full text-sm font-bold text-gray-400 pt-2">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function switchRole(role) {
            const studentTab = document.getElementById('studentTab');
            const lecturerTab = document.getElementById('lecturerTab');
            const formTitle = document.getElementById('formTitle');
            const formDesc = document.getElementById('formDesc');
            const idLabel = document.getElementById('idLabel');
            const roleInput = document.getElementById('roleInput');
            const usernameField = document.getElementById('usernameField');

            const activeClass = 'flex-1 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-[#0a3d62] text-white shadow-md flex items-center justify-center gap-2';
            const inactiveClass = 'flex-1 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-gray-400 hover:text-gray-600 flex items-center justify-center gap-2';

            if (role === 'student') {
                studentTab.className = activeClass;
                lecturerTab.className = inactiveClass;
                formTitle.innerText = 'Student Access';
                formDesc.innerText = 'Enter your ID to access the student portal';
                idLabel.innerText = 'Student ID';
                usernameField.placeholder = 'e.g. B20230123';
                roleInput.value = 'student';
            } else {
                lecturerTab.className = activeClass;
                studentTab.className = inactiveClass;
                formTitle.innerText = 'Lecturer Access';
                formDesc.innerText = 'Access management tools & student records';
                idLabel.innerText = 'Faculty ID / Email';
                usernameField.placeholder = 'e.g. FAC-99001';
                roleInput.value = 'lecturer';
            }
        }

        function toggleModal(show) {
            const modal = document.getElementById('forgotModal');
            if (show) modal.classList.remove('hidden');
            else modal.classList.add('hidden');
        }
    </script>
</body>
</html>