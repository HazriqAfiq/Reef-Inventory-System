<section>
    <div class="bg-rose-50/30 border border-rose-100 rounded-2xl p-6 mb-8">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-xl bg-white border border-rose-100 flex items-center justify-center text-rose-600 shrink-0 shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-rose-900">Irreversible Action</p>
                <p class="text-xs text-rose-600 mt-0.5 leading-relaxed">Deleting your account will purge all associated data, including transaction history and inventory records. This cannot be undone.</p>
            </div>
        </div>
    </div>

    <!-- Trigger Button -->
    <button type="button" id="delete-account-btn"
            class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-rose-600 text-xs font-bold uppercase tracking-widest rounded-xl border border-rose-100 hover:bg-rose-50 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Terminate Account
    </button>

    <!-- Confirm Modal -->
    <div id="delete-account-modal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 backdrop-blur-md bg-black/40 transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-md p-10 transform scale-100">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 flex items-center justify-center mb-6 text-rose-600 shadow-sm border border-rose-100">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Confirm Termination</h3>
                <p class="text-sm text-gray-500 mt-2">
                    Please provide your account password to verify your identity and confirm deletion.
                </p>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <div>
                    <label for="delete_password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Security Key</label>
                    <input id="delete_password" name="password" type="password" placeholder="••••••••"
                           class="w-full px-5 py-4 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl transition duration-300 focus:ring-2 focus:ring-black/5 focus:border-black {{ $errors->userDeletion->has('password') ? 'border-rose-400' : '' }}">
                    @if($errors->userDeletion->has('password'))
                        <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest px-1">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <button type="button" id="cancel-delete-btn"
                            class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 bg-white border border-gray-100 hover:text-black rounded-xl transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-lg shadow-rose-500/20 transition-all">
                        Destroy
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const delModal = document.getElementById('delete-account-modal');
        const triggerBtn = document.getElementById('delete-account-btn');
        const cancelBtn = document.getElementById('cancel-delete-btn');

        triggerBtn.addEventListener('click', () => {
            delModal.classList.remove('hidden');
            delModal.classList.add('flex');
        });

        cancelBtn.addEventListener('click', () => {
            delModal.classList.add('hidden');
            delModal.classList.remove('flex');
        });

        delModal.addEventListener('click', (e) => {
            if (e.target === delModal) {
                delModal.classList.add('hidden');
                delModal.classList.remove('flex');
            }
        });

        @if($errors->userDeletion->isNotEmpty())
            delModal.classList.remove('hidden');
            delModal.classList.add('flex');
        @endif
    </script>
</section>
