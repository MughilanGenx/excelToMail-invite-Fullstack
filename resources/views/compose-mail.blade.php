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
            --bg: #f8fafc; --surface: #ffffff; --text: #0f172a; --muted: #475569;
            --border: #e2e8f0; --accent: #3b82f6; --accent-h: #2563eb;
            --purple: #8b5cf6; --purple-h: #7c3aed; --purple-light: #ede9fe;
            --green-bg: #dcfce7; --green-text: #166534; --green-border: #bbf7d0;
            --red-bg: #fee2e2; --red-text: #991b1b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem; }
        .container { max-width: 820px; margin: 0 auto; }

        .nav { display: flex; gap: 1.5rem; margin-bottom: 2rem; }
        .nav a { color: var(--accent); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: color 0.2s; }
        .nav a:hover { color: var(--accent-h); }

        header { margin-bottom: 2rem; animation: fadeInDown 0.5s ease; }
        header h1 { font-size: 2rem; font-weight: 700; letter-spacing: -0.025em; }
        header p  { color: var(--muted); margin-top: 0.3rem; }

        .card {
            background: var(--surface); border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            padding: 2rem; margin-bottom: 1.5rem; animation: fadeInUp 0.5s ease;
        }

        .step-title {
            font-size: 0.85rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--purple);
            margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .step-num {
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--purple); color: white;
            font-size: 0.75rem; display: inline-flex; align-items: center; justify-content: center;
        }

        /* Alerts */
        .alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500; }
        .alert-success { background: var(--green-bg); color: var(--green-text); border: 1px solid var(--green-border); }
        .alert-error   { background: var(--red-bg);   color: var(--red-text);   border: 1px solid #fecaca; }
        .result-list   { margin-top: 0.5rem; font-size: 0.8rem; list-style: disc; padding-left: 1.25rem; }

        /* Form fields */
        .form-group { margin-bottom: 1.25rem; }
        .form-group:last-child { margin-bottom: 0; }
        .form-group label {
            display: block; font-size: 0.8rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: var(--muted); margin-bottom: 0.4rem;
        }
        .form-control {
            width: 100%; padding: 0.65rem 1rem;
            border: 1px solid var(--border); border-radius: 10px;
            font-family: 'Inter', sans-serif; font-size: 0.875rem;
            color: var(--text); background: var(--surface);
            outline: none; transition: border-color 0.25s, box-shadow 0.25s;
        }
        .form-control:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgb(139 92 246 / 0.15); }
        textarea.form-control { resize: vertical; min-height: 130px; line-height: 1.6; }

        /* Store URL row */
        .store-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media(max-width:560px) { .store-row { grid-template-columns: 1fr; } }

        .store-badge-preview {
            display: flex; align-items: center; gap: 0.5rem;
            margin-top: 0.4rem;
        }
        .store-badge-preview img { height: 28px; }
        .store-badge-preview span { font-size: 0.75rem; color: var(--muted); }

        /* Record selector */
        .record-cards { display: flex; flex-direction: column; gap: 0.65rem; }
        .record-option { display: none; }
        .record-label {
            display: flex; align-items: flex-start; gap: 1rem;
            border: 2px solid var(--border); border-radius: 12px;
            padding: 0.9rem 1.1rem; cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .record-label:hover { border-color: var(--purple); background: #faf5ff; }
        .record-option:checked + .record-label { border-color: var(--purple); background: var(--purple-light); }

        .record-dot {
            width: 17px; height: 17px; border-radius: 50%;
            border: 2px solid #c4b5fd; flex-shrink: 0; margin-top: 2px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .record-option:checked + .record-label .record-dot { border-color: var(--purple); background: var(--purple); }
        .record-option:checked + .record-label .record-dot::after {
            content: ''; display: block; width: 5px; height: 5px; border-radius: 50%; background: white;
        }
        .record-info strong { font-size: 0.9rem; color: var(--text); display: block; }
        .record-info .meta  { font-size: 0.75rem; color: var(--muted); margin-top: 0.15rem; }
        .record-info .preview { font-size: 0.75rem; color: var(--purple); font-family: monospace; margin-top: 0.3rem; word-break: break-all; }
        .count-badge { background: var(--green-bg); color: var(--green-text); padding: 0.15rem 0.6rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 600; flex-shrink: 0; }

        /* Name dropdown */
        .name-select {
            width: 100%; padding: 0.65rem 1rem;
            border: 1px solid var(--border); border-radius: 10px;
            font-family: 'Inter', sans-serif; font-size: 0.875rem;
            color: var(--text); background: var(--surface);
            outline: none; cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%238b5cf6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 14px;
        }
        .name-select:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgb(139 92 246 / 0.15); }

        /* Preview chips */
        .preview-panel { background: linear-gradient(135deg,#f5f3ff,#ede9fe); border: 1px solid #ddd6fe; border-radius: 10px; padding: 0.9rem 1.1rem; margin-top: 0.75rem; font-size: 0.82rem; }
        .preview-panel strong { color: var(--purple); display: block; margin-bottom: 0.5rem; }
        .chips { display: flex; flex-wrap: wrap; gap: 0.35rem; }
        .chip  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 9999px; padding: 0.15rem 0.6rem; font-size: 0.78rem; }

        /* Config notice */
        .config-notice { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 0.9rem 1.1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: #92400e; }
        .config-notice code { background: #fef3c7; padding: 0.1rem 0.35rem; border-radius: 4px; font-size: 0.78rem; }

        /* Send button */
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

        .empty-notice { text-align: center; padding: 3rem; color: var(--muted); }
        .empty-notice a { color: var(--accent); }
        .hint { font-size: 0.76rem; color: #94a3b8; margin-top: 0.35rem; }

        @keyframes fadeInDown { from{opacity:0;transform:translateY(-16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeInUp   { from{opacity:0;transform:translateY(16px)}  to{opacity:1;transform:translateY(0)} }
    </style>
</head>
<body>
<div class="container">

    <nav class="nav">
        <a href="{{ route('excel.index') }}">← Excel Extractor</a>
        <a href="{{ route('excel.saved') }}">📋 Saved Records</a>
    </nav>

    <header>
        <h1>✉️ Send Invitation Mail</h1>
        <p>Select email list + optional name list, compose, and send to everyone at once.</p>
    </header>

    <div class="config-notice">
        ⚙️ <strong>SMTP Setup:</strong> Set <code>MAIL_MAILER=smtp</code>, <code>MAIL_HOST</code>,
        <code>MAIL_USERNAME</code>, <code>MAIL_PASSWORD</code>, and <code>MAIL_FROM_ADDRESS</code> in your <code>.env</code>.
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if(session('sent_list') && count(session('sent_list')) > 0)
                <ul class="result-list">
                    @foreach(session('sent_list') as $s)
                        <li>✅ {{ $s }}</li>
                    @endforeach
                </ul>
            @endif
            @if(session('failed_list') && count(session('failed_list')) > 0)
                <ul class="result-list" style="margin-top:0.5rem;">
                    @foreach(session('failed_list') as $f)
                        <li>❌ {{ $f }}</li>
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
                <p>No saved records yet.</p>
                <p style="margin-top:0.5rem;">
                    <a href="{{ route('excel.index') }}">Upload an Excel file</a> and save a column first.
                </p>
            </div>
        </div>
    @else
        <form action="{{ route('mail.send') }}" method="POST" id="mailForm">
            @csrf

            {{-- STEP 1: Email List --}}
            <div class="card">
                <div class="step-title"><span class="step-num">1</span> Select Email List</div>
                <div class="record-cards">
                    @foreach($records as $record)
                        <div>
                            <input type="radio" name="record_id" id="email_record_{{ $record->id }}"
                                   value="{{ $record->id }}" class="record-option"
                                   data-emails="{{ implode(',', $record->values) }}"
                                   onchange="updateEmailPreview(this)">
                            <label for="email_record_{{ $record->id }}" class="record-label">
                                <div class="record-dot"></div>
                                <div class="record-info">
                                    <strong>{{ $record->column_name }}</strong>
                                    <span class="meta">Excel: <em>{{ $record->excel_column }}</em> · {{ $record->created_at->diffForHumans() }}</span>
                                    <span class="preview">[{{ Str::limit($record->data, 60) }}]</span>
                                </div>
                                <span class="count-badge">{{ count($record->values) }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('record_id')
                    <p style="color:#dc2626;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</p>
                @enderror
                <div id="emailPreview" class="preview-panel" style="display:none;margin-top:0.75rem;">
                    <strong id="emailPreviewTitle">📧 Recipients:</strong>
                    <div class="chips" id="emailChips"></div>
                </div>
            </div>

            {{-- STEP 2: Name List (optional) --}}
            <div class="card">
                <div class="step-title"><span class="step-num">2</span> Select Name Column <span style="font-weight:400;font-size:0.8rem;color:var(--muted);text-transform:none;">(optional — greets by name)</span></div>
                <select name="name_record_id" class="name-select">
                    <option value="">— No name column (will show email instead) —</option>
                    @foreach($records as $record)
                        <option value="{{ $record->id }}" {{ old('name_record_id') == $record->id ? 'selected' : '' }}>
                            {{ $record->column_name }} ({{ $record->excel_column }}) — {{ count($record->values) }} values
                        </option>
                    @endforeach
                </select>
                <p class="hint">💡 Make sure the name column has the same number of rows as the email column — they will be paired by row index.</p>
            </div>

            {{-- STEP 3: Compose --}}
            <div class="card">
                <div class="step-title"><span class="step-num">3</span> Compose Message</div>

                <div class="form-group">
                    <label>Sender Name</label>
                    <input type="text" name="from_name" class="form-control"
                           placeholder="e.g. TC Events Team"
                           value="{{ old('from_name', config('app.name')) }}">
                </div>

                <div class="form-group">
                    <label>Subject *</label>
                    <input type="text" name="subject" class="form-control"
                           placeholder="Task Concierge is Live — Download Now!"
                           value="{{ old('subject') }}" required>
                </div>

                <div class="form-group">
                    <label>Message Body *</label>
                    <textarea name="body" class="form-control"
                              placeholder="Write a short personal message to your users…" required>{{ old('body') }}</textarea>
                </div>
            </div>

            {{-- STEP 4: Store Links --}}
            <div class="card">
                <div class="step-title"><span class="step-num">4</span> App Store Links</div>

                <div class="store-row">
                    <div class="form-group">
                        <label>Apple App Store URL</label>
                        <input type="url" name="app_store_link" class="form-control"
                               placeholder="https://apps.apple.com/app/..."
                               value="{{ old('app_store_link') }}">
                        <div class="store-badge-preview">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
                            <span>This badge will appear in the email</span>
                        </div>
                        @error('app_store_link')
                            <p style="color:#dc2626;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Google Play Store URL</label>
                        <input type="url" name="play_store_link" class="form-control"
                               placeholder="https://play.google.com/store/apps/..."
                               value="{{ old('play_store_link') }}">
                        <div class="store-badge-preview">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                            <span>This badge will appear in the email</span>
                        </div>
                        @error('play_store_link')
                            <p style="color:#dc2626;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-send" id="sendBtn">
                🚀 Send Invitation to All Recipients
            </button>
        </form>
    @endif
</div>

<script>
    function updateEmailPreview(radio) {
        const emails = (radio.dataset.emails || '').split(',').map(e => e.trim()).filter(Boolean);
        const preview = document.getElementById('emailPreview');
        const chips   = document.getElementById('emailChips');
        const title   = document.getElementById('emailPreviewTitle');
        if (emails.length) {
            title.textContent = `📧 ${emails.length} Recipient(s):`;
            chips.innerHTML = emails.map(e => `<span class="chip">${e}</span>`).join('');
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
