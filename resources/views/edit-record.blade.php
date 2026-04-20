<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record — {{ $record->column_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc; --surface: #fff; --text: #0f172a; --muted: #475569;
            --border: #e2e8f0; --accent: #3b82f6; --accent-h: #2563eb;
            --purple: #8b5cf6; --purple-h: #7c3aed; --purple-light: #ede9fe;
            --red: #dc2626; --red-bg: #fee2e2; --red-border: #fecaca;
            --green-bg: #dcfce7; --green-text: #166534; --green-border: #bbf7d0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem; }
        .container { max-width: 780px; margin: 0 auto; }

        .nav { display: flex; gap: 1.5rem; margin-bottom: 2rem; }
        .nav a { color: var(--accent); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: color 0.2s; }
        .nav a:hover { color: var(--accent-h); }

        header { margin-bottom: 2rem; animation: fadeInDown 0.5s ease; }
        header h1 { font-size: 1.9rem; font-weight: 700; letter-spacing: -0.025em; }
        header p  { color: var(--muted); margin-top: 0.3rem; font-size: 0.9rem; }

        .card {
            background: var(--surface); border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            padding: 2rem; margin-bottom: 1.5rem;
            animation: fadeInUp 0.5s ease;
        }

        .section-label {
            font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--purple); margin-bottom: 0.75rem;
        }

        .form-group { margin-bottom: 1.25rem; }
        .form-group label {
            display: block; font-size: 0.78rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: var(--muted); margin-bottom: 0.4rem;
        }
        .form-control {
            width: 100%; padding: 0.65rem 1rem;
            border: 1px solid var(--border); border-radius: 10px;
            font-family: 'Inter', sans-serif; font-size: 0.9rem;
            color: var(--text); background: var(--surface);
            outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgb(139 92 246 / 0.15); }

        /* ---- Values List ---- */
        #values-list { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; }

        .value-row {
            display: flex; align-items: center; gap: 0.5rem;
            animation: fadeIn 0.25s ease;
        }

        .value-row .row-num {
            font-size: 0.72rem; font-weight: 600; color: var(--muted);
            min-width: 26px; text-align: right; flex-shrink: 0;
        }

        .value-input {
            flex: 1; padding: 0.55rem 0.9rem;
            border: 1px solid var(--border); border-radius: 8px;
            font-family: 'Inter', sans-serif; font-size: 0.875rem;
            color: var(--text); outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .value-input:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgb(139 92 246 / 0.12); }

        .btn-remove {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--red-bg); border: 1px solid var(--red-border);
            color: var(--red); font-size: 1rem; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: background 0.2s;
        }
        .btn-remove:hover { background: #fecaca; }

        .btn-add {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--purple-light); color: var(--purple);
            border: 1px dashed var(--purple); border-radius: 8px;
            padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 600;
            cursor: pointer; transition: background 0.2s;
            font-family: 'Inter', sans-serif; width: 100%; justify-content: center;
        }
        .btn-add:hover { background: #ddd6fe; }

        .stats-bar {
            display: flex; gap: 1rem; align-items: center;
            background: #f8f5ff; border: 1px solid #e9d5ff;
            border-radius: 10px; padding: 0.65rem 1rem;
            margin-bottom: 1rem; font-size: 0.82rem;
        }
        .stats-bar strong { color: var(--purple); }

        /* Action buttons */
        .action-row { display: flex; gap: 1rem; align-items: center; }
        .btn-save {
            flex: 1; padding: 0.85rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white; border: none; border-radius: 10px;
            font-weight: 700; font-size: 1rem; cursor: pointer;
            transition: opacity 0.2s; font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 12px rgb(139 92 246 / 0.3);
        }
        .btn-save:hover { opacity: 0.9; }

        .btn-cancel {
            padding: 0.85rem 1.5rem;
            background: #f1f5f9; color: var(--muted);
            border: 1px solid var(--border); border-radius: 10px;
            font-weight: 600; font-size: 0.9rem; cursor: pointer;
            transition: background 0.2s; font-family: 'Inter', sans-serif;
            text-decoration: none; display: inline-flex; align-items: center;
        }
        .btn-cancel:hover { background: #e2e8f0; }

        .hint { font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem; }

        @keyframes fadeInDown { from{opacity:0;transform:translateY(-16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeInUp   { from{opacity:0;transform:translateY(16px)}  to{opacity:1;transform:translateY(0)} }
        @keyframes fadeIn     { from{opacity:0} to{opacity:1} }
    </style>
</head>
<body>
<div class="container">

    <nav class="nav">
        <a href="{{ route('excel.saved') }}">← Back to Saved Records</a>
        <a href="{{ route('excel.index') }}">📊 Excel Extractor</a>
    </nav>

    <header>
        <h1>✏️ Edit Record</h1>
        <p>Modify the column name, label, or individual values — then save back to the database.</p>
    </header>

    <form action="{{ route('excel.update', $record->id) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        {{-- Meta fields --}}
        <div class="card">
            <div class="section-label">Column Info</div>

            <div class="form-group">
                <label>Custom Field Name *</label>
                <input type="text" name="column_name" class="form-control"
                       value="{{ old('column_name', $record->column_name) }}" required
                       placeholder="e.g. email_list, user_names…">
                @error('column_name')
                    <p style="color:var(--red);font-size:0.78rem;margin-top:0.3rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Excel Header (Original Column Name)</label>
                <input type="text" name="excel_column" class="form-control"
                       value="{{ old('excel_column', $record->excel_column) }}"
                       placeholder="e.g. Email, Name, Phone…">
                @error('excel_column')
                    <p style="color:var(--red);font-size:0.78rem;margin-top:0.3rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Values editor --}}
        <div class="card">
            <div class="section-label">Edit Values</div>
            <p class="hint" style="margin-bottom:1rem;">
                Edit individual values below. Click ✕ to remove a row, or <strong>+ Add Value</strong> to add a new one.
                Values will be re-imploded as <code>val1,val2,val3</code> on save.
            </p>

            <div class="stats-bar">
                <span>Total values: <strong id="valueCount">{{ count($record->values) }}</strong></span>
            </div>

            <div id="values-list">
                @foreach($record->values as $i => $val)
                    <div class="value-row" id="row-{{ $i }}">
                        <span class="row-num">{{ $i + 1 }}</span>
                        <input type="text" name="values[]" class="value-input"
                               value="{{ $val }}" placeholder="Enter value…"
                               oninput="updateCount()">
                        <button type="button" class="btn-remove" onclick="removeRow(this)" title="Remove">✕</button>
                    </div>
                @endforeach
            </div>

            @error('values')
                <p style="color:var(--red);font-size:0.78rem;margin-bottom:0.5rem;">{{ $message }}</p>
            @enderror

            <button type="button" class="btn-add" onclick="addRow()">
                + Add Value
            </button>
        </div>

        {{-- Save / Cancel --}}
        <div class="action-row">
            <a href="{{ route('excel.saved') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">💾 Save Changes</button>
        </div>
    </form>
</div>

<script>
    function updateCount() {
        const inputs = document.querySelectorAll('#values-list .value-input');
        const filled = Array.from(inputs).filter(i => i.value.trim() !== '').length;
        document.getElementById('valueCount').textContent = filled;
    }

    function removeRow(btn) {
        const row = btn.closest('.value-row');
        row.style.opacity = '0';
        row.style.transform = 'translateX(20px)';
        row.style.transition = 'all 0.2s ease';
        setTimeout(() => {
            row.remove();
            renumberRows();
            updateCount();
        }, 200);
    }

    function renumberRows() {
        document.querySelectorAll('#values-list .value-row').forEach((row, idx) => {
            const num = row.querySelector('.row-num');
            if (num) num.textContent = idx + 1;
        });
    }

    function addRow() {
        const list  = document.getElementById('values-list');
        const count = list.querySelectorAll('.value-row').length;
        const div   = document.createElement('div');
        div.className = 'value-row';
        div.innerHTML = `
            <span class="row-num">${count + 1}</span>
            <input type="text" name="values[]" class="value-input"
                   placeholder="Enter value…" oninput="updateCount()" autofocus>
            <button type="button" class="btn-remove" onclick="removeRow(this)" title="Remove">✕</button>
        `;
        list.appendChild(div);
        div.querySelector('input').focus();
        updateCount();
    }

    // Initial count
    updateCount();
</script>
</body>
</html>
