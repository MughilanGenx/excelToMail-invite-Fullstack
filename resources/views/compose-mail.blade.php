<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Invitation Mail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #475569;
            --border: #e2e8f0;
            --accent: #3b82f6;
            --accent-h: #2563eb;
            --purple: #8b5cf6;
            --purple-h: #7c3aed;
            --purple-light: #ede9fe;
            --green-bg: #dcfce7;
            --green-text: #166534;
            --green-border: #bbf7d0;
            --red-bg: #fee2e2;
            --red-text: #991b1b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 2rem;
        }
        .container { max-width: 780px; margin: 0 auto; }

        /* Nav */
        .nav { display: flex; gap: 1.5rem; margin-bottom: 2rem; }
        .nav a {
            color: var(--accent); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; transition: color 0.2s;
        }
        .nav a:hover { color: var(--accent-h); }

        /* Header */
        header { margin-bottom: 2rem; animation: fadeInDown 0.5s ease; }
        header h1 { font-size: 2rem; font-weight: 700; letter-spacing: -0.025em; }
        header p  { color: var(--muted); margin-top: 0.3rem; }

        /* Card */
        .card {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            padding: 2rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.5s ease;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem; border-radius: 10px;
            margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500;
        }
        .alert-success {
            background: var(--green-bg); color: var(--green-text);
            border: 1px solid var(--green-border);
        }
        .alert-error {
            background: var(--red-bg); color: var(--red-text);
            border: 1px solid #fecaca;
        }
        .failed-list {
            margin-top: 0.5rem; font-size: 0.8rem; list-style: disc; padding-left: 1.25rem;
        }

        /* Form */
        .form-group { margin-bottom: 1.5rem; }
        .form-group label {
            display: block; font-size: 0.8rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: var(--muted); margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%; padding: 0.7rem 1rem;
            border: 1px solid var(--border); border-radius: 10px;
            font-family: 'Inter', sans-serif; font-size: 0.9rem;
            color: var(--text); background: var(--surface);
            outline: none; transition: border-color 0.25s, box-shadow 0.25s;
        }
        .form-control:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgb(139 92 246 / 0.15);
        }

        textarea.form-control { resize: vertical; min-height: 140px; line-height: 1.6; }

        /* Record selector */
        .record-cards { display: flex; flex-direction: column; gap: 0.75rem; }
        .record-option { display: none; }
        .record-label {
            display: flex; align-items: flex-start; gap: 1rem;
            border: 2px solid var(--border); border-radius: 12px;
            padding: 1rem 1.25rem; cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .record-label:hover { border-color: var(--purple); background: #faf5ff; }
        .record-option:checked + .record-label {
            border-color: var(--purple);
            background: var(--purple-light);
        }
        .record-dot {
            width: 18px; height: 18px; border-radius: 50%;
            border: 2px solid #c4b5fd; flex-shrink: 0; margin-top: 2px;
            transition: border-color 0.2s, background 0.2s;
            display: flex; align-items: center; justify-content: center;
        }
        .record-option:checked + .record-label .record-dot {
            border-color: var(--purple); background: var(--purple);
        }
        .record-option:checked + .record-label .record-dot::after {
            content: ''; display: block; width: 6px; height: 6px;
            border-radius: 50%; background: white;
        }
        .record-info { flex: 1; }
        .record-info strong { font-size: 0.95rem; color: var(--text); display: block; }
        .record-info .meta {
            font-size: 0.78rem; color: var(--muted); margin-top: 0.2rem;
        }
        .record-info .preview {
            font-size: 0.78rem; color: var(--purple);
            font-family: 'Courier New', monospace;
            margin-top: 0.4rem;
            word-break: break-all;
        }
        .count-badge {
            background: var(--green-bg); color: var(--green-text);
            padding: 0.15rem 0.6rem; border-radius: 9999px;
            font-size: 0.72rem; font-weight: 600; flex-shrink: 0;
        }

        /* Preview panel */
        .preview-panel {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            border: 1px solid #ddd6fe; border-radius: 12px;
            padding: 1rem 1.25rem; margin-top: 0.75rem;
            font-size: 0.82rem;
        }
        .preview-panel strong { color: var(--purple); display: block; margin-bottom: 0.5rem; }
        .chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
        .chip {
            background: #eff6ff; color: #1d4ed8;
            border: 1px solid #bfdbfe; border-radius: 9999px;
            padding: 0.15rem 0.65rem; font-size: 0.78rem;
        }

        /* Config notice */
        .config-notice {
            background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.85rem; color: #92400e;
        }
        .config-notice code {
            background: #fef3c7; padding: 0.1rem 0.4rem;
            border-radius: 4px; font-size: 0.8rem;
        }

        /* Submit */
        .btn-send {
            width: 100%; padding: 0.9rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white; border: none; border-radius: 10px;
            font-weight: 700; font-size: 1rem; cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 4px 12px rgb(139 92 246 / 0.3);
            font-family: 'Inter', sans-serif;
        }
        .btn-send:hover   { opacity: 0.92; }
        .btn-send:active  { transform: scale(0.99); }
        .btn-send:disabled{ opacity: 0.5; cursor: not-allowed; }

        .empty-notice {
            text-align: center; padding: 3rem; color: var(--muted);
        }
        .empty-notice a { color: var(--accent); }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-16px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeInUp   { from { opacity:0; transform:translateY(16px);  } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
<div class="container">

    <!-- Nav -->
    <nav class="nav">
        <a href="{{ route('excel.index') }}">← Excel Extractor</a>
        <a href="{{ route('excel.saved') }}">📋 Saved Records</a>
    </nav>

    <header>
        <h1>✉️ Send Invitation Mail</h1>
        <p>Select a saved email list, compose your message, and send to all addresses at once.</p>
    </header>

    {{-- SMTP config notice --}}
    <div class="config-notice">
        ⚙️ <strong>SMTP Setup:</strong> Configure your mail settings in <code>.env</code> —
        set <code>MAIL_MAILER=smtp</code>, <code>MAIL_HOST</code>, <code>MAIL_PORT</code>,
        <code>MAIL_USERNAME</code>, <code>MAIL_PASSWORD</code>, and <code>MAIL_FROM_ADDRESS</code>
        before sending real emails.
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if(session('failed_list') && count(session('failed_list')) > 0)
                <ul class="failed-list">
                    @foreach(session('failed_list') as $f)
                        <li>{{ $f }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($records->isEmpty())
        <div class="card">
            <div class="empty-notice">
                <p>No saved email records found.</p>
                <p style="margin-top:0.5rem;">
                    <a href="{{ route('excel.index') }}">Upload an Excel file</a> and save a column first.
                </p>
            </div>
        </div>
    @else
        <form action="{{ route('mail.send') }}" method="POST" id="mailForm">
            @csrf

            <!-- Step 1: Select email list -->
            <div class="card">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Step 1 — Select Email List</label>
                    <div class="record-cards" style="margin-top:0.75rem;">
                        @foreach($records as $record)
                            <div>
                                <input type="radio" name="record_id" id="record_{{ $record->id }}"
                                       value="{{ $record->id }}" class="record-option"
                                       data-emails="{{ implode(',', $record->values) }}"
                                       data-count="{{ count($record->values) }}"
                                       onchange="updatePreview(this)">
                                <label for="record_{{ $record->id }}" class="record-label">
                                    <div class="record-dot"></div>
                                    <div class="record-info">
                                        <strong>{{ $record->column_name }}</strong>
                                        <span class="meta">
                                            Excel column: <em>{{ $record->excel_column }}</em>
                                            &nbsp;·&nbsp; Saved {{ $record->created_at->diffForHumans() }}
                                        </span>
                                        <span class="preview">[{{ $record->data }}]</span>
                                    </div>
                                    <span class="count-badge">{{ count($record->values) }} emails</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @error('record_id')
                        <p style="color:#dc2626;font-size:0.8rem;margin-top:0.5rem;">{{ $message }}</p>
                    @enderror

                    <!-- Live preview of selected emails -->
                    <div id="emailPreview" class="preview-panel" style="display:none;">
                        <strong id="previewTitle">📧 Recipients:</strong>
                        <div class="chips" id="previewChips"></div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Compose -->
            <div class="card">
                <div class="form-group">
                    <label>Step 2 — Sender Name</label>
                    <input type="text" name="from_name" class="form-control"
                           placeholder="e.g. TC Events Team"
                           value="{{ old('from_name', config('app.name')) }}">
                    @error('from_name')
                        <p style="color:#dc2626;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Subject *</label>
                    <input type="text" name="subject" class="form-control"
                           placeholder="You're invited to…"
                           value="{{ old('subject') }}" required>
                    @error('subject')
                        <p style="color:#dc2626;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label>Message Body *</label>
                    <textarea name="body" class="form-control"
                              placeholder="Write your invitation message here…" required>{{ old('body') }}</textarea>
                    @error('body')
                        <p style="color:#dc2626;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Send Button -->
            <button type="submit" class="btn-send" id="sendBtn">
                🚀 Send Invitation to All Recipients
            </button>
        </form>
    @endif
</div>

<script>
    function updatePreview(radio) {
        const rawEmails = radio.dataset.emails || '';
        const emails    = rawEmails.split(',').map(e => e.trim()).filter(Boolean);
        const preview   = document.getElementById('emailPreview');
        const chips     = document.getElementById('previewChips');
        const title     = document.getElementById('previewTitle');

        if (emails.length) {
            title.textContent = `📧 ${emails.length} Recipient(s):`;
            chips.innerHTML   = emails.map(e => `<span class="chip">${e}</span>`).join('');
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    document.getElementById('mailForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('sendBtn');
        btn.disabled = true;
        btn.textContent = '⏳ Sending…';
    });
</script>
</body>
</html>
