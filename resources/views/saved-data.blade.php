<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Column Records</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #f8fafc;
            --surface-bg: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #475569;
            --accent-color: #3b82f6;
            --border-color: #e2e8f0;
            --save-color: #8b5cf6;
            --success-bg: #dcfce7;
            --success-text: #166534;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            line-height: 1.6;
            padding: 2rem;
            min-height: 100vh;
        }
        .container { max-width: 1100px; margin: 0 auto; }
        header { margin-bottom: 2rem; animation: fadeInDown 0.6s ease-out; }
        header h1 { font-size: 2rem; font-weight: 700; letter-spacing: -0.025em; }
        header p  { color: var(--text-secondary); margin-top: 0.25rem; }
        .nav-links { display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .nav-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            color: var(--accent-color); font-size: 0.875rem; font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .nav-link:hover { color: #2563eb; }
        .btn-send-mail {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white; padding: 0.4rem 1rem;
            border-radius: 8px; font-size: 0.8rem; font-weight: 600;
            text-decoration: none; transition: opacity 0.2s;
            box-shadow: 0 2px 8px rgb(139 92 246 / 0.3);
        }
        .btn-send-mail:hover { opacity: 0.88; color: white; }

        .card {
            background: var(--surface-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            overflow: hidden;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.5s ease-out;
        }

        .card-header {
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            border-bottom: 1px solid #ddd6fe;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .card-header-left h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--save-color);
        }

        .card-header-left p {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.2rem;
        }

        .meta-badges { display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; }

        .badge {
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-purple { background: #ede9fe; color: var(--save-color); }
        .badge-green  { background: var(--success-bg); color: var(--success-text); }
        .badge-gray   { background: #f1f5f9; color: var(--text-secondary); }

        .action-btns { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }

        .btn-edit {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: #eff6ff; color: #2563eb;
            border: 1px solid #bfdbfe;
            padding: 0.3rem 0.85rem; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600;
            text-decoration: none; transition: background 0.2s;
        }
        .btn-edit:hover { background: #dbeafe; color: #1d4ed8; }

        .btn-delete {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: #fee2e2; color: #dc2626;
            border: 1px solid #fecaca;
            padding: 0.3rem 0.85rem; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600;
            cursor: pointer; transition: background 0.2s;
            font-family: inherit;
        }
        .btn-delete:hover { background: #fecaca; }

        .alert {
            padding: 0.9rem 1.25rem; border-radius: 10px;
            margin-bottom: 1.5rem; font-size: 0.875rem; font-weight: 500;
        }
        .alert-success { background: var(--success-bg); color: var(--success-text); border: 1px solid #bbf7d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .values-area {
            padding: 1.25rem 1.5rem;
        }

        .values-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
        }

        /* Raw imploded string */
        .raw-string {
            font-family: 'Courier New', monospace;
            font-size: 0.82rem;
            color: #1e293b;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            word-break: break-all;
            margin-bottom: 1rem;
        }
        .raw-string .bracket { color: var(--save-color); font-weight: 700; }

        /* Exploded chips */
        .chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
        .chip {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 9999px;
            padding: 0.2rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 500;
            transition: background 0.2s;
        }
        .chip:hover { background: #dbeafe; }

        /* Empty state */
        .empty { text-align: center; padding: 4rem 2rem; color: var(--text-secondary); }
        .empty-icon { font-size: 3rem; margin-bottom: 1rem; }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeInUp   { from { opacity:0; transform:translateY(20px);  } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="{{ route('excel.index') }}" class="nav-link">← Back to Excel Extractor</a>
            <a href="{{ route('mail.compose') }}" class="nav-link">✉️ Send Mail →</a>
        </div>

        <header>
            <h1>📋 Saved Column Records</h1>
            <p>All columns saved from Excel files — stored as imploded strings, displayed as exploded values.</p>
        </header>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        @if($records->isEmpty())
            <div class="card">
                <div class="empty">
                    <div class="empty-icon">🗂️</div>
                    <p>No records saved yet. Upload an Excel file and save a column to see it here.</p>
                </div>
            </div>
        @else
            @foreach($records as $record)
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <h3>{{ $record->column_name }}</h3>
                            <p>Excel Header: <strong>{{ $record->excel_column }}</strong> &nbsp;·&nbsp; Saved: {{ $record->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="action-btns">
                            <span class="badge badge-green">{{ count($record->values) }} values</span>
                            <span class="badge badge-gray">ID #{{ $record->id }}</span>
                            <a href="{{ route('mail.compose') }}" class="btn-send-mail">✉️ Send Mail</a>
                            <a href="{{ route('excel.edit', $record->id) }}" class="btn-edit">✏️ Edit</a>
                            <form action="{{ route('excel.destroy', $record->id) }}" method="POST"
                                  onsubmit="return confirm('Delete record &quot;{{ addslashes($record->column_name) }}&quot;? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">🗑️ Delete</button>
                            </form>
                        </div>
                    </div>

                    <div class="values-area">
                        {{-- Raw DB value (imploded) --}}
                        <div class="values-label">Stored in DB (imploded string)</div>
                        <div class="raw-string">
                            <span class="bracket">[</span>{{ $record->data }}<span class="bracket">]</span>
                        </div>

                        {{-- Exploded values as chips --}}
                        <div class="values-label">Exploded values</div>
                        <div class="chips">
                            @foreach($record->values as $val)
                                <span class="chip">{{ $val }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
