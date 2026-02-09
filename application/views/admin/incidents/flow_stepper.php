<?php
// Define steps
$steps = [
    1 => ['title' => 'Reporting', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
    2 => ['title' => 'Triage', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
    3 => ['title' => 'Assignment', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
    4 => ['title' => 'Investigation', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
    5 => ['title' => 'Mitigation', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
    6 => ['title' => 'Recovery', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
];

// Current active step passed from view
$current_step = isset($active_step) ? $active_step : 1;
?>

<div class="mb-8 overflow-x-auto pb-2">
    <div class="flex items-center justify-between min-w-[700px]">
        <?php foreach ($steps as $step_num => $step): ?>
            <?php 
                $is_completed = $step_num < $current_step;
                $is_current = $step_num === $current_step;
                $is_pending = $step_num > $current_step;
            ?>
            <?php 
                // Fix layering: Earlier steps must be on top of later steps 
                // so that the "next" step's line (extending left) goes BEHIND the "current" step's circle.
                $z_index = 60 - ($step_num * 10); 
            ?>
            <div class="flex flex-col items-center relative w-32 group" style="z-index: <?= $z_index ?>">
                <!-- Connector Line -->
                <?php if ($step_num != 1): ?>
                    <div class="absolute top-5 right-[50%] w-[200%] h-1 -z-10 
                        <?= $is_completed || $is_current ? 'bg-gradient-to-r from-rri-blue to-rri-blue/50' : 'bg-gray-200 dark:bg-slate-700' ?>"></div>
                <?php endif; ?>

                <!-- Circle Icon -->
                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300
                    <?= $is_completed 
                        ? 'bg-rri-blue text-white shadow-lg shadow-blue-500/30' 
                        : ($is_current 
                            ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900 shadow-xl scale-110' 
                            : 'bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-600 text-gray-400 dark:text-slate-500') ?>">
                    
                    <?php if ($is_completed): ?>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $step['icon'] ?>"></path>
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- Title -->
                <span class="text-xs font-semibold uppercase tracking-wider text-center
                    <?= $is_current 
                        ? 'text-blue-600 dark:text-blue-400' 
                        : ($is_completed ? 'text-gray-900 dark:text-gray-300' : 'text-gray-400 dark:text-slate-500') ?>">
                    <?= $step['title'] ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
