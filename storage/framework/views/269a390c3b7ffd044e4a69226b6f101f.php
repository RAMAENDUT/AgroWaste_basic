<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'AgroWaste Academy'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-neutral-900">
    <?php if(auth()->guard()->check()): ?>
    <!-- Authenticated Layout with Sidebar -->
    <div class="min-h-screen flex bg-neutral-900">
        <!-- Sidebar -->
        <aside class="w-60 hidden md:flex flex-col bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-green-50">
            <div class="px-5 pt-6 pb-4 border-b border-green-700/40">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 font-semibold">
                    <span class="w-8 h-8 flex items-center justify-center rounded-md bg-yellow-500 text-neutral-900 text-lg">🌱</span>
                    <span class="leading-tight">
                        <span>AgroWaste</span><br />
                        <span class="text-[10px] font-normal text-green-200">Academy</span>
                    </span>
                </a>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1 text-sm">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 px-3 py-2 rounded-md transition <?php echo e(request()->is('home') ? 'bg-green-600 text-white shadow' : 'text-green-200 hover:bg-green-700/50'); ?>">
                    <span>🏠</span><span>Home</span>
                </a>
                <a href="<?php echo e(route('modules.index')); ?>" class="flex items-center gap-2 px-3 py-2 rounded-md transition <?php echo e(request()->is('modules*') || request()->is('videos*') || request()->is('quizzes*') ? 'bg-green-600 text-white shadow' : 'text-green-200 hover:bg-green-700/50'); ?>">
                    <span>📚</span><span>Modul Pembelajaran</span>
                </a>
            </nav>
            <div class="mt-auto p-4 space-y-4 text-[11px]">
                <div class="bg-green-700/40 rounded-md p-3 leading-relaxed">
                    Platform edukasi untuk mengelola limbah pertanian menjadi produk bernilai ekonomi tinggi
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="grid">
                    <?php echo csrf_field(); ?>
                    <button class="px-3 py-2 rounded-md border border-green-600 text-green-100 hover:bg-green-600/20 text-xs flex items-center gap-2" type="submit">
                        ↪ Logout
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 bg-neutral-50 overflow-y-auto">
            <?php if(session('success')): ?>
                <div class="px-8 pt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="px-8 pt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <?php else: ?>
    <!-- Guest Layout (Landing, Login, Register) -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php endif; ?>
</body>
</html>
<?php /**PATH D:\ketapang\Agro Waste\resources\views/layouts/app.blade.php ENDPATH**/ ?>