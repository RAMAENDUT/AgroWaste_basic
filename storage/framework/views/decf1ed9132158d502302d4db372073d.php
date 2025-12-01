

<?php $__env->startSection('title', $module->title . ' - AgroWaste Academy'); ?>

<?php $__env->startSection('content'); ?>
<div class="px-8 py-8">
    <div class="space-y-4 max-w-4xl">
        <div class="p-4 bg-white shadow rounded">
            <h1 class="text-2xl font-semibold mb-2"><?php echo e($module->title); ?></h1>
            <p class="text-gray-700 mb-4"><?php echo e($module->description); ?></p>
            
            <div class="prose max-w-none mb-6">
                <?php echo $module->content; ?>

            </div>
            
            <div class="flex gap-3">
                <?php if($firstVideo): ?>
                    <a href="<?php echo e(route('videos.show', $firstVideo->id)); ?>" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Tonton Video</a>
                <?php endif; ?>
                <?php if($firstQuiz): ?>
                    <a href="<?php echo e(route('quizzes.show', $firstQuiz->id)); ?>" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Kerjakan Kuis</a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($videos->count() > 0): ?>
        <div>
            <h3 class="font-semibold mb-2">Video (<?php echo e($videos->count()); ?>)</h3>
            <ul class="list-disc ml-5 text-sm">
                <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a class="text-blue-600 hover:underline" href="<?php echo e(route('videos.show', $v->id)); ?>"><?php echo e($v->title); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if($firstQuiz): ?>
        <div>
            <h3 class="font-semibold mb-2">Kuis</h3>
            <p class="text-sm">Passing score: <?php echo e($firstQuiz->passing_score); ?>%</p>
            <p class="text-sm text-gray-600 mt-1"><?php echo e($firstQuiz->questions->count()); ?> pertanyaan tersedia</p>
            <?php if($progress && $progress->quiz_completed): ?>
                <div class="mt-2 inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">
                    ✓ Selesai (Skor: <?php echo e($progress->quiz_score); ?>)
                </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div>
            <h3 class="font-semibold mb-2">Kuis</h3>
            <p class="text-sm text-gray-500">Belum ada kuis.</p>
        </div>
        <?php endif; ?>

        <?php if($progress): ?>
            <div class="bg-gray-100 rounded p-4">
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-medium">Progress Modul</span>
                    <span class="text-green-600 font-semibold"><?php echo e($progress->getProgressPercentage()); ?>%</span>
                </div>
                <div class="w-full bg-gray-300 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e($progress->getProgressPercentage()); ?>%"></div>
                </div>
                <?php if($progress->isFullyCompleted()): ?>
                    <div class="mt-3 text-center text-sm text-green-700 font-semibold">
                        🎉 Modul selesai!
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ketapang\Agro Waste\resources\views/modules/show.blade.php ENDPATH**/ ?>