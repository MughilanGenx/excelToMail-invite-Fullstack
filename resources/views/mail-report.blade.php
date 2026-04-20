<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Send Report #{{ $log->id }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc; --surface: #ffffff; --text: #0f172a; --muted: #475569;
            --border: #e2e8f0; --accent: #3b82f6; --accent-h: #2563eb;
            --purple: #8b5cf6; --success: #10b981; --danger: #ef4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem; }
        .container { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }
        @media(max-width: 768px) { .container { grid-template-columns: 1fr; } }
        
        .nav { display: flex; gap: 1.5rem; margin-bottom: 2rem; grid-column: 1 / -1; }
        .nav a { color: var(--accent); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: color 0.2s; }
        .nav a:hover { color: var(--accent-h); }
        
        .card { background: var(--surface); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 1.5rem; }
        
        /* Stats Summary */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat-box { padding: 1.25rem; border-radius: 10px; text-align: center; border: 1px solid var(--border); }
        .stat-box.total { background: #f1f5f9; }
        .stat-box.sent { background: #dcfce7; border-color: #bbf7d0; color: #166534; }
        .stat-box.failed { background: #fee2e2; border-color: #fecaca; color: #991b1b; }
        .stat-value { font-size: 2rem; font-weight: 700; line-height: 1; margin-bottom: 0.25rem; }
        .stat-label { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; }
        
        /* Log Details Table */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th, td { padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid var(--border); }
        th { font-weight: 600; color: var(--muted); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; background: #f8fafc; }
        .status-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .status-sent { background: #dcfce7; color: #166534; }
        .status-failed { background: #fee2e2; color: #991b1b; }
        .error-msg { font-family: monospace; font-size: 0.8rem; color: #dc2626; display: block; margin-top: 0.25rem; }
        
        /* Sidebar History */
        .history-list { display: flex; flex-direction: column; gap: 0.75rem; }
        .history-item { display: block; padding: 1rem; border-radius: 8px; border: 1px solid var(--border); text-decoration: none; color: inherit; transition: all 0.2s; }
        .history-item:hover { border-color: var(--purple); background: #faf5ff; }
        .history-item.active { border-color: var(--purple); background: #ede9fe; pointer-events: none; }
        .history-item strong { display: block; font-size: 0.9rem; margin-bottom: 0.25rem; }
        .history-item .meta { font-size: 0.75rem; color: var(--muted); display: flex; justify-content: space-between; align-items: center; }
        .success-rate { font-weight: 600; color: var(--success); }
        .success-rate.low { color: var(--danger); }
    </style>
</head>
<body>

<div class="container">
    <nav class="nav">
        <a href="{{ route('mail.compose') }}">← Compose New Mail</a>
        <a href="{{ route('excel.saved') }}">📋 Saved Records</a>
    </nav>
    
    <!-- Sidebar: Past Sends -->
    <aside class="sidebar">
        <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Send History</h3>
        <div class="history-list">
            @foreach($allLogs as $l)
                <a href="{{ route('mail.report', $l->id) }}" class="history-item {{ $l->id === $log->id ? 'active' : '' }}">
                    <strong>{{ Str::limit($l->subject, 30) }}</strong>
                    <div class="meta">
                        <span>{{ $l->created_at->format('M d, H:i') }}</span>
                        <span class="success-rate {{ $l->successRate() < 100 ? 'low' : '' }}">
                            {{ $l->successRate() }}% Sent
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </aside>

    <!-- Main Content: Detailed Report -->
    <main class="report-content">
        <div style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.8rem; margin-bottom: 0.5rem;">Report: {{ $log->subject }}</h1>
            <p style="color: var(--muted); font-size: 0.9rem;">
                Sent on {{ $log->created_at->format('F j, Y, g:i a') }} 
                @if($log->record)
                    to list "<strong>{{ $log->record->column_name }}</strong>"
                @endif
            </p>
        </div>

        <div class="stats-grid">
            <div class="stat-box total">
                <div class="stat-value">{{ $log->total }}</div>
                <div class="stat-label">Total Recipients</div>
            </div>
            <div class="stat-box sent">
                <div class="stat-value">{{ $log->sent }}</div>
                <div class="stat-label">Successfully Sent</div>
            </div>
            <div class="stat-box failed">
                <div class="stat-value">{{ $log->failed }}</div>
                <div class="stat-label">Failed</div>
            </div>
        </div>

        <div class="card" style="padding: 0;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
                <h3 style="font-size: 1.1rem; margin: 0;">Recipient Details</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Recipient</th>
                            <th width="100">Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($log->details as $detail)
                            <tr>
                                <td>
                                    @if($detail->recipient_name)
                                        <div style="font-weight: 500;">{{ $detail->recipient_name }}</div>
                                    @endif
                                    <div style="color: var(--muted); font-size: 0.8rem;">{{ $detail->email }}</div>
                                </td>
                                <td>
                                    @if($detail->status === 'sent')
                                        <span class="status-badge status-sent">✅ Sent</span>
                                    @else
                                        <span class="status-badge status-failed">❌ Failed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($detail->status === 'failed')
                                        <span class="error-msg">{{ $detail->error ?: 'Unknown error' }}</span>
                                    @else
                                        <span style="color: var(--muted); font-size: 0.8rem;">Delivered</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        
                        @if($log->details->isEmpty())
                            <tr>
                                <td colspan="3" style="text-align: center; color: var(--muted); padding: 2rem;">
                                    No details recorded for this send.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</div>

</body>
</html>
