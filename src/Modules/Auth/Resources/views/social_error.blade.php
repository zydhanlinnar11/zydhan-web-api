@extends('auth::layouts.master')

@section('title', 'Email already exists')

@section('content')
<div class="min-h-screen flex flex-col">
    <nav
        class="bg-zinc-900/25 sticky top-0 min-h-[52px] sm:h-[52px] z-10 w-full backdrop-blur-[20px] backdrop-saturate-[1.80] after:w-full after:h-px after:bg-white/[0.24] after:content-[''] after:block after:absolute after:top-full"
    >
        <div
            class="flex justify-start h-[52px] my-0 mx-auto py-0 max-w-5xl px-6"
        >
            <a class="my-auto font-semibold text-lg" href="/"
                ><h1>Zydhan Linnar Putra</h1></a
            >
        </div>
    </nav>
    <main class="flex flex-col mx-auto grow w-full max-w-5xl px-6">
        <div class="my-auto">
            <header class="flex flex-col min-h-24 my-16 text-center mx-auto">
                <h1 class="text-4xl font-bold">Email already registered</h1>
                <h2 class="text-lg my-2 text-gray-400 text-center">
                    Login to your existing account to link this social account.
                </h2>
                <div class="w-[10rem] mx-auto">
                    <button
                        id="close-button"
                        class="rounded-md border-2 border-opacity-50 border-gray-600 w-full h-10 mt-3 hover:bg-blue-600 hover:bg-opacity-30 transition-colors duration-100 focus:bg-blue-900 focus:bg-opacity-30"
                    >
                        Close
                    </button>
                </div>
            </header>
        </div>
    </main>
    <footer class="h-7 mx-auto text-gray-300 mb-5 w-full max-w-5xl px-6">
        <div class="h-px w-full bg-white/[0.24]"></div>
        <div class="flex justify-between mt-2">
            <div>
                <small
                    >©
                    <!-- -->2022<!-- -->
                    Zydhan Linnar Putra.</small
                >
            </div>
            <div class="flex gap-3">
                <a
                    href="https://github.com/zydhanlinnar11"
                    target="_blank"
                    rel="noreferrer"
                    class="max-h-3 max-w-3 text-white/75 hover:text-white/90 focus:text-white"
                    aria-label="Follow my Github"
                    ><i class="fa-brands fa-lg fa-github"></i>
                </a>
                <a
                    href="https://www.linkedin.com/in/zydhanlinnar11"
                    target="_blank"
                    rel="noreferrer"
                    class="max-h-3 max-w-3 text-white/75 hover:text-white/90 focus:text-white"
                    aria-label="Follow my LinkedIn"
                    ><i class="fa-brands fa-lg fa-linkedin"></i>
                </a>
            </div>
        </div>
    </footer>
</div>
<script>
    document.getElementById("close-button").addEventListener("click", () => {
        window.close();
    });
</script>
@endsection
