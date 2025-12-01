

<?php $__env->startSection('title', 'Home - AgroWaste Academy'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative isolate">
    <div class="bg-gradient-to-r from-green-900 via-green-800 to-green-600 text-white px-8 pt-14 pb-24">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center gap-2 text-yellow-400 text-sm mb-4">
                🌱 <span class="text-green-100">AgroWaste Academy</span>
            </div>
            <h1 class="text-4xl font-bold leading-tight mb-2">
                <?php
                    $hour = date('G');
                    $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                ?>
                <?php echo e($greeting); ?>, <?php echo e(Auth::user()->name); ?>! 👋
            </h1>
            <p class="text-lg text-green-100">Siap melanjutkan pembelajaran Anda hari ini?</p>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 max-w-3xl">
                <div class="bg-white/10 backdrop-blur rounded-lg p-4 border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center text-2xl">📚</div>
                        <div>
                            <p class="text-2xl font-bold"><?php echo e($totalModules); ?></p>
                            <p class="text-xs text-green-200">Modul Diikuti</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-lg p-4 border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-2xl">⏳</div>
                        <div>
                            <p class="text-2xl font-bold"><?php echo e($totalModules - $completedModules); ?></p>
                            <p class="text-xs text-green-200">Sedang Berjalan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-lg p-4 border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-2xl">✅</div>
                        <div>
                            <p class="text-2xl font-bold"><?php echo e($completedModules); ?></p>
                            <p class="text-xs text-green-200">Modul Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex gap-3">
                <a href="<?php echo e(route('modules.index')); ?>" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-400 text-neutral-900 font-semibold text-sm rounded-lg shadow-lg">Jelajahi Modul Baru</a>
                <a href="<?php echo e(route('modules.index')); ?>" class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white font-medium text-sm rounded-lg border border-white/30">Lihat Modul Saya</a>
            </div>
        </div>
    </div>
    
    <!-- Metrics Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-8 py-10 bg-gradient-to-r from-green-50 via-amber-50/40 to-green-50 text-center max-w-6xl mx-auto">
        <div>
            <p class="text-3xl font-bold text-green-900"><?php echo e($totalModules); ?>+</p>
            <p class="mt-1 text-xs font-medium text-gray-700">Modul Tersedia</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-green-900"><?php echo e($totalModules * 3); ?>+</p>
            <p class="mt-1 text-xs font-medium text-gray-700">Video Tutorial</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-green-900">100+</p>
            <p class="mt-1 text-xs font-medium text-gray-700">Petani Bergabung</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-green-900">95%</p>
            <p class="mt-1 text-xs font-medium text-gray-700">Kepuasan Pengguna</p>
        </div>
    </div>
</section>

<!-- Recent Modules Section -->
<?php if($modules->count() > 0): ?>
<section class="px-8 py-16 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Modul Populer</h2>
                <p class="text-sm text-gray-600 mt-1">Mulai belajar dari modul terpopuler</p>
            </div>
            <a href="<?php echo e(route('modules.index')); ?>" class="text-sm font-medium text-green-600 hover:text-green-700">Lihat Semua →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow overflow-hidden group">
                    <div class="relative h-40 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                        <span class="text-7xl opacity-20">
                            <?php if($loop->index == 0): ?> 🌾
                            <?php elseif($loop->index == 1): ?> 🌱
                            <?php else: ?> 🐄
                            <?php endif; ?>
                        </span>
                        <div class="absolute top-3 right-3 bg-white px-3 py-1 rounded-full text-xs font-medium capitalize shadow">
                            <?php echo e($loop->index == 0 ? 'Pemula' : ($loop->index == 1 ? 'Menengah' : 'Lanjutan')); ?>

                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-base text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                            <?php echo e($module->title); ?>

                        </h3>
                        <p class="text-xs text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                            <?php echo e(Str::limit($module->description, 100)); ?>

                        </p>
                        
                        <?php
                            $progress = $userProgress->where('module_id', $module->id)->first();
                        ?>
                        
                        <?php if($progress): ?>
                            <div class="mb-4">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">Progress</span>
                                    <span class="text-green-600 font-semibold"><?php echo e($progress->getProgressPercentage()); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-green-600 h-1.5 rounded-full" style="width: <?php echo e($progress->getProgressPercentage()); ?>%"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('modules.show', $module->slug)); ?>" class="block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Features Section -->
<section class="px-8 py-16">
    <h2 class="text-2xl font-bold text-center mb-2">Fitur Pembelajaran</h2>
    <p class="text-sm text-gray-600 text-center mb-10">Berbagai metode pembelajaran yang dirancang khusus untuk petani Indonesia</p>
    <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-xl mb-4">📘</div>
            <h3 class="font-semibold mb-1 text-sm">Modul Terstruktur</h3>
            <p class="text-xs text-gray-600 leading-relaxed">Modul lengkap dengan materi, video, dan latihan terintegrasi</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-xl mb-4">🎬</div>
            <h3 class="font-semibold mb-1 text-sm">Video Tutorial</h3>
            <p class="text-xs text-gray-600 leading-relaxed">Tutorial praktis dan mudah dipahami untuk petani</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-xl mb-4">📝</div>
            <h3 class="font-semibold mb-1 text-sm">Latihan Interaktif</h3>
            <p class="text-xs text-gray-600 leading-relaxed">Uji pemahaman dengan latihan soal dan tracking progress</p>
        </div>
    </div>
</section>

<!-- Reasons Section -->
<section class="px-8 py-24 bg-gradient-to-b from-amber-50 to-white">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div class="rounded-lg overflow-hidden shadow-md bg-gradient-to-br from-green-400 to-blue-500 h-72 flex items-center justify-center">
            <span class="text-9xl opacity-20">🌱</span>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-6">Mengapa Mengelola Limbah Pertanian?</h2>
            <ul class="space-y-5">
                <li class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-md bg-green-600 text-white flex items-center justify-center text-lg">✅</div>
                    <div>
                        <p class="font-semibold text-sm mb-1">Meningkatkan Pendapatan</p>
                        <p class="text-xs text-gray-600 leading-relaxed">Ubah limbah menjadi produk bernilai seperti kompos, pupuk organik, dan biogas</p>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-md bg-green-600 text-white flex items-center justify-center text-lg">♻️</div>
                    <div>
                        <p class="font-semibold text-sm mb-1">Ramah Lingkungan</p>
                        <p class="text-xs text-gray-600 leading-relaxed">Kurangi pencemaran dan jaga kesuburan tanah untuk generasi mendatang</p>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-md bg-green-600 text-white flex items-center justify-center text-lg">🌿</div>
                    <div>
                        <p class="font-semibold text-sm mb-1">Pertanian Berkelanjutan</p>
                        <p class="text-xs text-gray-600 leading-relaxed">Terapkan praktik pertanian modern yang efisien dan berkelanjutan</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-28 bg-gradient-to-r from-green-700 to-orange-600 text-white text-center">
    <h2 class="text-3xl font-bold mb-4">Siap Meningkatkan Nilai Pertanian Anda?</h2>
    <p class="text-sm max-w-2xl mx-auto mb-6 leading-relaxed">Bergabunglah dengan ratusan petani yang telah merasakan manfaat pengelolaan limbah pertanian</p>
    <a href="<?php echo e(route('modules.index')); ?>" class="inline-block bg-white text-green-700 px-6 py-3 rounded-md text-sm font-semibold shadow hover:bg-green-50">Mulai Sekarang Gratis</a>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ketapang\Agro Waste\resources\views/home.blade.php ENDPATH**/ ?>