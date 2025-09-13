<div class="relative">
    <!-- Background decoration -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 rounded-3xl -z-10"></div>

    <div class="px-8 py-12 text-center">
        <!-- Avatar/Icon Section -->
        <div class="relative mb-6">
            <div
                class="inline-flex items-center justify-center w-20 h-20 mb-2 shadow-lg rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-600">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <!-- Success badge -->
            <div
                class="absolute flex items-center justify-center w-6 h-6 rounded-full shadow-md -top-1 -right-1 bg-emerald-500">
                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="mb-8">
            <h2 class="mb-3 text-4xl font-bold text-slate-900">
                Welcome, <span
                    class="text-transparent bg-gradient-to-r from-yellow-300 to-yellow-600 bg-clip-text">{{ Auth::user()->name }}</span>!
            </h2>
            <p class="max-w-2xl mx-auto text-lg leading-relaxed text-slate-600">
                Congratulations on joining our platform! Let's complete your business profile setup to unlock all
                features and get you started on your journey to success.
            </p>
        </div>

        <!-- Progress Indicator -->
        <div class="flex items-center justify-center mb-8 space-x-2">
            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
            <div class="w-8 h-1 rounded-full bg-slate-200">
                <div class="w-2 h-1 rounded-full bg-emerald-500"></div>
            </div>
            <div class="w-3 h-3 rounded-full bg-slate-200"></div>
            <div class="w-8 h-1 rounded-full bg-slate-200"></div>
            <div class="w-3 h-3 rounded-full bg-slate-200"></div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-3">
            <div class="p-4 border bg-white/70 backdrop-blur-sm rounded-xl border-slate-200/50">
                <div class="text-2xl font-bold text-slate-900">2-3</div>
                <div class="text-sm text-slate-600">Minutes to complete</div>
            </div>
            <div class="p-4 border bg-white/70 backdrop-blur-sm rounded-xl border-slate-200/50">
                <div class="text-2xl font-bold text-slate-900">3</div>
                <div class="text-sm text-slate-600">Simple steps</div>
            </div>
            <div class="p-4 border bg-white/70 backdrop-blur-sm rounded-xl border-slate-200/50">
                <div class="text-2xl font-bold text-slate-900">100%</div>
                <div class="text-sm text-slate-600">Secure process</div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="flex flex-col items-center space-y-4">
            <a href="{{ route('app.client.onbaord.account-setup') }}" wire:navigate
                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white transition-all duration-200 transform bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl hover:from-yellow-500 hover:to-yellow-800 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-yellow-200 group">
                <svg class="w-5 h-5 mr-3 transition-transform group-hover:translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                Proceed to Business Account Setup
                <div class="w-2 h-2 ml-3 rounded-full bg-white/30 animate-pulse"></div>
            </a>

            <!-- Alternative action -->
            <button
                class="inline-flex items-center px-4 py-2 text-sm font-medium transition-colors rounded-lg text-slate-600 hover:text-slate-800 hover:bg-slate-100">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Need help? Watch our 2-minute guide
            </button>
        </div>

        <!-- Trust indicators -->
        <div class="flex items-center justify-center mt-8 space-x-6 text-sm text-slate-500">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.5-2a2.5 2.5 0 00-5 0 2.5 2.5 0 005 0z" />
                </svg>
                SSL Secured
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Privacy Protected
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Quick Setup
            </div>
        </div>
    </div>
</div>
