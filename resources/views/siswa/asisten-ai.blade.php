@extends('layouts.siswa')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <header class="flex items-center gap-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-800">
            <i data-feather="message-circle" class="h-6 w-6"></i>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Teman Membaca</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Asisten Perpustakaan</h1>
            <p class="mt-1 text-sm text-slate-600">Cari buku di katalog atau tanyakan cara mengajukan peminjaman.</p>
        </div>
    </header>

    <section class="overflow-hidden rounded-3xl border border-blue-100 bg-white shadow-sm">
        <div class="flex items-center gap-3 border-b border-blue-100 bg-blue-50/80 px-5 py-4">
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-800 text-white"><i data-feather="book-open" class="h-5 w-5"></i></span>
            <div>
                <p class="font-semibold text-slate-800">Pustaka</p>
                <p class="text-xs text-slate-500">Asisten offline Luxurious</p>
            </div>
            <span class="ml-auto inline-flex items-center gap-2 text-xs font-medium text-emerald-700">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>Siap membantu
            </span>
        </div>

        <div id="chat-messages" role="log" aria-live="polite" aria-label="Percakapan dengan asisten" class="flex min-h-72 max-h-[55vh] flex-col gap-4 overflow-y-auto bg-gradient-to-b from-white to-sky-50/50 p-5 sm:p-7">
            <div class="max-w-[90%] self-start rounded-2xl rounded-tl-md border border-blue-100 bg-white px-4 py-3 text-sm leading-relaxed text-slate-700 shadow-sm">
                Halo! Aku asisten offline yang bisa membantu mencari buku di katalog dan menjelaskan cara mengajukan peminjaman. Kamu sedang mencari buku apa?
            </div>
        </div>

        <div class="border-t border-slate-100 px-5 py-4 sm:px-7">
            <p class="mb-3 text-xs font-medium text-slate-500">Coba tanyakan:</p>
            <div class="mb-4 flex flex-wrap gap-2">
                <button type="button" class="suggestion rounded-full border border-blue-200 bg-white px-3 py-1.5 text-xs font-medium text-blue-800 transition hover:bg-blue-50">Rekomendasikan buku untuk saya</button>
                <button type="button" class="suggestion rounded-full border border-blue-200 bg-white px-3 py-1.5 text-xs font-medium text-blue-800 transition hover:bg-blue-50">Ada buku tentang teknologi?</button>
                <button type="button" class="suggestion rounded-full border border-blue-200 bg-white px-3 py-1.5 text-xs font-medium text-blue-800 transition hover:bg-blue-50">Bagaimana cara meminjam buku?</button>
            </div>
            <form id="chat-form" class="flex items-end gap-3">
                @csrf
                <label for="chat-input" class="sr-only">Tulis pertanyaan</label>
                <textarea id="chat-input" rows="1" maxlength="1000" required placeholder="Tulis pertanyaanmu..." class="max-h-32 min-h-12 flex-1 resize-y rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"></textarea>
                <button id="send-button" type="submit" class="inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-2xl bg-blue-900 px-5 text-sm font-semibold text-white transition hover:bg-blue-950 disabled:cursor-not-allowed disabled:opacity-60">
                    <i data-feather="send" class="h-4 w-4"></i><span class="hidden sm:inline">Kirim</span>
                </button>
            </form>
            <p id="chat-status" role="status" class="mt-3 min-h-5 text-xs text-slate-500">Asisten ini bekerja offline dengan pencarian kata kunci katalog; untuk informasi lain, hubungi petugas.</p>
        </div>
    </section>
</div>

<script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const messagesContainer = document.getElementById('chat-messages');
    const sendButton = document.getElementById('send-button');
    const statusText = document.getElementById('chat-status');
    const messages = [];

    function appendMessage(text, role) {
        const bubble = document.createElement('div');
        bubble.className = role === 'user'
            ? 'max-w-[90%] self-end rounded-2xl rounded-tr-md bg-blue-900 px-4 py-3 text-sm leading-relaxed text-white shadow-sm'
            : 'max-w-[90%] self-start rounded-2xl rounded-tl-md border border-blue-100 bg-white px-4 py-3 text-sm leading-relaxed text-slate-700 shadow-sm';
        bubble.textContent = text;
        messagesContainer.appendChild(bubble);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        return bubble;
    }

    document.querySelectorAll('.suggestion').forEach((button) => {
        button.addEventListener('click', () => {
            input.value = button.textContent.trim();
            input.focus();
        });
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const question = input.value.trim();
        if (!question || sendButton.disabled) return;

        messages.push({ role: 'user', text: question });
        appendMessage(question, 'user');
        input.value = '';
        sendButton.disabled = true;
        statusText.textContent = 'Asisten sedang menyiapkan jawaban...';
        const loadingBubble = appendMessage('Sedang berpikir...', 'assistant');

        while (messages.length > 10) {
            messages.splice(0, 2);
        }

        try {
            const response = await fetch(@json(route('siswa.asisten-ai.tanya')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({ messages }),
            });
            const result = await response.json();
            loadingBubble.remove();

            if (!response.ok) {
                throw new Error(result.message || 'Asisten tidak dapat menjawab saat ini.');
            }

            messages.push({ role: 'assistant', text: result.reply });
            appendMessage(result.reply, 'assistant');
            statusText.textContent = 'Asisten ini bekerja offline dengan pencarian kata kunci katalog; untuk informasi lain, hubungi petugas.';
        } catch (error) {
            const message = error instanceof Error ? error.message : 'Terjadi kesalahan. Silakan coba lagi.';
            appendMessage(message, 'assistant');
            statusText.textContent = message;
        } finally {
            sendButton.disabled = false;
            input.focus();
            if (window.feather) feather.replace();
        }
    });
</script>
@endsection
