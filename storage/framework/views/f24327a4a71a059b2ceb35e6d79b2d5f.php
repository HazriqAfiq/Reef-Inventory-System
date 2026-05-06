<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laman Store')); ?> | Laman Store Malaysia</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Prata&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <style>
            [x-cloak] { display: none !important; }
            :root {
                --font-serif: "Prata", serif;
                --font-sans: 'Inter', sans-serif;
            }
            .font-luxury { font-family: var(--font-serif); }
            .font-serif { font-family: var(--font-serif); }
            body { 
                font-family: var(--font-sans);
                background-color: #ffffff;
            }

            /* Cinematic Animations */
            @keyframes zoom-slow {
                from { transform: scale(1); }
                to { transform: scale(1.15); }
            }
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-zoom-slow { animation: zoom-slow 20s infinite alternate ease-in-out; }
            .animate-fade-in-up { animation: fade-in-up 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            .animate-fade-in-up.delay-300 { animation-delay: 0.3s; opacity: 0; }
        </style>
    </head>
    <body class="antialiased bg-[#FAFAFA] text-gray-900 relative overflow-x-hidden">
        <div class="relative z-10 min-h-screen">
            <?php echo e($slot); ?>

        </div>
    </body>
</html>
<?php /**PATH C:\Users\USER\Documents\Project Code\perfume_store\resources\views/layouts/guest.blade.php ENDPATH**/ ?>