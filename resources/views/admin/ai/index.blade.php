@extends('layouts.layout')

@section('title', 'OpenCode AI')
@section('breadcrumb', 'OpenCode AI')

@section('content')

<style>
    .ai-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        transition: border-color .25s, box-shadow .25s;
    }
    .ai-card:hover {
        border-color: rgba(50, 230, 34, 0.25);
        box-shadow: 0 0 0 1px rgba(50, 230, 34, 0.08), var(--shadow-md);
    }
    .ai-card-header {
        padding: 1.25rem 1.5rem 0;
    }
    .ai-card-body {
        padding: 1.25rem 1.5rem 1.5rem;
    }
    .ai-label {
        display: block;
        font-size: .75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--text-muted);
        margin-bottom: .5rem;
    }
    .ai-input {
        width: 100%;
        padding: .65rem .9rem;
        background: #1c1c1c;
        border: 1px solid var(--border);
        border-radius: 10px;
        color: #e2e8f0;
        font-size: .875rem;
        font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .ai-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(50, 230, 34, 0.12);
    }
    .ai-input::placeholder {
        color: #555;
        font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
    }
    select.ai-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23888' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .9rem center;
        padding-right: 2.2rem;
    }
    select.ai-input option {
        background: #1a1a1a;
        color: #e2e8f0;
    }
    textarea.ai-input {
        resize: vertical;
        min-height: 5rem;
    }
    .ai-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .65rem 1.25rem;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 600;
        font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        cursor: pointer;
        transition: all .2s;
        border: none;
        white-space: nowrap;
    }
    .ai-btn-primary {
        background: var(--primary);
        color: #000;
    }
    .ai-btn-primary:hover {
        background: #2fd41f;
        box-shadow: 0 0 20px rgba(50, 230, 34, 0.25);
    }
    .ai-btn-primary:active {
        transform: scale(.97);
    }
    .ai-btn-primary:disabled {
        opacity: .5;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
    .ai-output {
        margin-top: 1rem;
        padding: 1rem 1.15rem;
        background: #0f0f0f;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: .875rem;
        color: #d1d5db;
        line-height: 1.65;
        min-height: 3rem;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .ai-output p:last-child {
        margin-bottom: 0;
    }
    .ai-spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid rgba(0,0,0,.2);
        border-top-color: #000;
        border-radius: 50%;
        animation: ai-spin .6s linear infinite;
    }
    @keyframes ai-spin {
        to { transform: rotate(360deg); }
    }
    .ai-empty {
        color: #555;
        font-style: italic;
    }
    .ai-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .2rem .7rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        background: rgba(50, 230, 34, 0.12);
        color: var(--primary);
        border: 1px solid rgba(50, 230, 34, 0.2);
    }
    .ai-error {
        color: #fc8181;
        background: rgba(252, 129, 129, 0.1);
        border: 1px solid rgba(252, 129, 129, 0.2);
    }
    @media (max-width: 600px) {
        .ai-card-header,
        .ai-card-body {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .ai-btn {
            width: 100%;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fa fa-microchip" style="color:var(--primary);margin-right:10px;"></i>OpenCode AI
        </h1>
        <p class="page-subtitle">ប្រើប្រាស់ AI ដើម្បីបង្កើនប្រសិទ្ធភាពការងាររបស់អ្នក</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{─ ─── Card 1: Generate Food Description ─── ──}}
    <div class="ai-card">
        <div class="ai-card-header flex items-center justify-between flex-wrap gap-2">
            <h3 style="font-size:1rem;font-weight:700;color:#fff;display:flex;align-items:center;gap:.6rem;">
                <i class="fa fa-pen-fancy" style="color:var(--primary);"></i>ពិពណ៌នាម្ហូប
            </h3>
            <span class="ai-badge"><i class="fa fa-bolt"></i> AI</span>
        </div>
        <div class="ai-card-body">
            <div class="mb-4" style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                <div>
                    <label class="ai-label">ឈ្មោះម្ហូប</label>
                    <input type="text" id="desc-name" class="ai-input" placeholder="e.g. បាយឆាគុយទាវ" value="">
                </div>
                <div>
                    <label class="ai-label">ប្រភេទ</label>
                    <input type="text" id="desc-category" class="ai-input" placeholder="e.g. បាយ" value="">
                </div>
            </div>
            <div class="mb-4" style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                <div>
                    <label class="ai-label">តម្លៃ ($)</label>
                    <input type="number" id="desc-price" class="ai-input" placeholder="0.00" min="0" step="0.01" value="">
                </div>
                <div>
                    <label class="ai-label">ពាក្យគន្លឹះ</label>
                    <input type="text" id="desc-keywords" class="ai-input" placeholder="e.g. ហឹរ, ក្រអូប">
                </div>
            </div>
            <button onclick="generateDescription()" id="desc-btn" class="ai-btn ai-btn-primary w-full">
                <i class="fa fa-wand-magic-sparkles"></i> បង្កើតការពិពណ៌នា
            </button>
            <div id="desc-output" class="ai-output"><span class="ai-empty">ចុចប៊ូតុងដើម្បីបង្កើត...</span></div>
        </div>
    </div>

    {{─ ─── Card 2: Order Trends Analysis ─── ──}}
    <div class="ai-card">
        <div class="ai-card-header flex items-center justify-between flex-wrap gap-2">
            <h3 style="font-size:1rem;font-weight:700;color:#fff;display:flex;align-items:center;gap:.6rem;">
                <i class="fa fa-chart-line" style="color:var(--primary);"></i>វិភាគនិន្នាការលក់
            </h3>
            <span class="ai-badge"><i class="fa fa-bolt"></i> AI</span>
        </div>
        <div class="ai-card-body">
            <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.25rem;line-height:1.6;">
                វិភាគការបញ្ជាទិញ ៥០ ចុងក្រោយ ដើម្បីស្វែងយល់ពីនិន្នាការ មុខម្ហូបដែលពេញនិយម
                និងចំណូល។
            </p>
            <button onclick="analyseTrends()" id="trends-btn" class="ai-btn ai-btn-primary w-full">
                <i class="fa fa-magnifying-glass-chart"></i> វិភាគឥឡូវនេះ
            </button>
            <div id="trends-output" class="ai-output"><span class="ai-empty">ចុចប៊ូតុងដើម្បីវិភាគ...</span></div>
        </div>
    </div>

    {{─ ─── Card 3: Smart Customer Reply ─── ──}}
    <div class="ai-card">
        <div class="ai-card-header flex items-center justify-between flex-wrap gap-2">
            <h3 style="font-size:1rem;font-weight:700;color:#fff;display:flex;align-items:center;gap:.6rem;">
                <i class="fa fa-comment-dots" style="color:var(--primary);"></i>ឆ្លើយតបអតិថិជន
            </h3>
            <span class="ai-badge"><i class="fa fa-bolt"></i> AI</span>
        </div>
        <div class="ai-card-body">
            <div class="mb-4">
                <label class="ai-label">ឈ្មោះអតិថិជន</label>
                <input type="text" id="reply-name" class="ai-input" placeholder="e.g. សុខា">
            </div>
            <div class="mb-4">
                <label class="ai-label">បរិបទ</label>
                <select id="reply-context" class="ai-input">
                    <option value="review">ការវាយតម្លៃ / មតិ</option>
                    <option value="complaint">ការត្អូញត្អែរ</option>
                    <option value="inquiry">ការសាកសួរ</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="ai-label">សាររបស់អតិថិជន</label>
                <textarea id="reply-message" class="ai-input" rows="3" placeholder="វាយបញ្ចូលសាររបស់អតិថិជននៅទីនេះ..."></textarea>
            </div>
            <button onclick="generateReply()" id="reply-btn" class="ai-btn ai-btn-primary w-full">
                <i class="fa fa-reply"></i> បង្កើតចម្លើយ
            </button>
            <div id="reply-output" class="ai-output"><span class="ai-empty">ចុចប៊ូតុងដើម្បីបង្កើតចម្លើយ...</span></div>
        </div>
    </div>

    {{─ ─── Card 4: Custom AI Prompt ─── ──}}
    <div class="ai-card">
        <div class="ai-card-header flex items-center justify-between flex-wrap gap-2">
            <h3 style="font-size:1rem;font-weight:700;color:#fff;display:flex;align-items:center;gap:.6rem;">
                <i class="fa fa-message" style="color:var(--primary);"></i>សាកសួរ AI ផ្ទាល់
            </h3>
            <span class="ai-badge"><i class="fa fa-bolt"></i> AI</span>
        </div>
        <div class="ai-card-body">
            <div class="mb-4">
                <label class="ai-label">System Hint <span style="color:#555;font-weight:400;text-transform:none;letter-spacing:0;">(ស្រេចចិត្ត)</span></label>
                <input type="text" id="prompt-system" class="ai-input" placeholder="ណែនាំ AI អំពីរបៀបឆ្លើយតប..." value="You are a helpful AI assistant for THORNG DY'S SHOP, a Khmer food e-commerce store. Respond in Khmer where appropriate.">
            </div>
            <div class="mb-4">
                <label class="ai-label">សំណួរ ឬពាក្យបញ្ជា</label>
                <textarea id="prompt-text" class="ai-input" rows="3" placeholder="សួរអ្វីដែលអ្នកចង់ដឹង..."></textarea>
            </div>
            <button onclick="sendPrompt()" id="prompt-btn" class="ai-btn ai-btn-primary w-full">
                <i class="fa fa-paper-plane"></i> ផ្ញើ
            </button>
            <div id="prompt-output" class="ai-output"><span class="ai-empty">ចុចប៊ូតុងដើម្បីផ្ញើ...</span></div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    function setLoading(btnId, outputId, loading) {
        const btn = document.getElementById(btnId);
        const out = document.getElementById(outputId);
        if (!btn) return;
        btn.disabled = loading;
        if (loading) {
            btn.dataset.html = btn.innerHTML;
            btn.innerHTML = '<span class="ai-spinner"></span> កំពុងដំណើរការ...';
            if (out) out.innerHTML = '<span class="ai-empty">កំពុងដំណើរការ...</span>';
        } else {
            btn.innerHTML = btn.dataset.html || btn.innerHTML;
        }
    }

    function showOutput(id, data) {
        const el = document.getElementById(id);
        if (!el) return;
        if (data.success && data.data) {
            el.innerHTML = '<p>' + data.data.replace(/\n/g, '<br>') + '</p>';
        } else {
            el.className = 'ai-output ai-error';
            el.innerHTML = '<i class="fa fa-circle-exclamation" style="margin-right:.4rem;"></i> ' + (data.error || 'Unknown error');
            setTimeout(() => el.className = 'ai-output', 3500);
        }
    }

    async function postJson(url, body) {
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify(body),
        });
        return res.json();
    }

    async function generateDescription() {
        const name = document.getElementById('desc-name').value.trim();
        const category = document.getElementById('desc-category').value.trim();
        const price = document.getElementById('desc-price').value;
        const keywords = document.getElementById('desc-keywords').value.trim();
        if (!name || !category || !price) {
            document.getElementById('desc-output').innerHTML = '<span style="color:#fc8181;">សូមបំពេញឈ្មោះម្ហូប ប្រភេទ និងតម្លៃ។</span>';
            return;
        }
        setLoading('desc-btn', 'desc-output', true);
        try {
            const data = await postJson('{{ route("admin.ai.generate-description") }}', { name, category, price, keywords });
            showOutput('desc-output', data);
        } catch (e) {
            document.getElementById('desc-output').innerHTML = '<span style="color:#fc8181;">ការតភ្ជាប់បរាជ័យ។ សូមព្យាយាមម្តងទៀត។</span>';
        }
        setLoading('desc-btn', null, false);
    }

    async function analyseTrends() {
        setLoading('trends-btn', 'trends-output', true);
        try {
            const res = await fetch('{{ route("admin.ai.order-trends") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            showOutput('trends-output', data);
        } catch (e) {
            document.getElementById('trends-output').innerHTML = '<span style="color:#fc8181;">ការតភ្ជាប់បរាជ័យ។ សូមព្យាយាមម្តងទៀត។</span>';
        }
        setLoading('trends-btn', null, false);
    }

    async function generateReply() {
        const customer_name = document.getElementById('reply-name').value.trim();
        const message = document.getElementById('reply-message').value.trim();
        const context = document.getElementById('reply-context').value;
        if (!customer_name || !message) {
            document.getElementById('reply-output').innerHTML = '<span style="color:#fc8181;">សូមបំពេញឈ្មោះអតិថិជន និងសារ។</span>';
            return;
        }
        setLoading('reply-btn', 'reply-output', true);
        try {
            const data = await postJson('{{ route("admin.ai.customer-reply") }}', { customer_name, message, context });
            showOutput('reply-output', data);
        } catch (e) {
            document.getElementById('reply-output').innerHTML = '<span style="color:#fc8181;">ការតភ្ជាប់បរាជ័យ។ សូមព្យាយាមម្តងទៀត។</span>';
        }
        setLoading('reply-btn', null, false);
    }

    async function sendPrompt() {
        const prompt = document.getElementById('prompt-text').value.trim();
        const system_hint = document.getElementById('prompt-system').value.trim();
        if (!prompt) {
            document.getElementById('prompt-output').innerHTML = '<span style="color:#fc8181;">សូមបញ្ចូលសំណួរ ឬពាក្យបញ្ជា។</span>';
            return;
        }
        setLoading('prompt-btn', 'prompt-output', true);
        try {
            const data = await postJson('{{ route("admin.ai.custom-prompt") }}', { prompt, system_hint });
            showOutput('prompt-output', data);
        } catch (e) {
            document.getElementById('prompt-output').innerHTML = '<span style="color:#fc8181;">ការតភ្ជាប់បរាជ័យ។ សូមព្យាយាមម្តងទៀត។</span>';
        }
        setLoading('prompt-btn', null, false);
    }
</script>
@endpush

@endsection
