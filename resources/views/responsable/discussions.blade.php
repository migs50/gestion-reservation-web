@extends('layouts.app')

@section('title', 'Modération des Discussions')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .page-header {
        background: linear-gradient(135deg, #676f9d 0%, #424769 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 0;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <span></span> Modération des Discussions
    </h1>
</div>

    <div class="discussions-list" style="display: flex; flex-direction: column; gap: 20px;">
        @forelse($discussions as $discussion)
            <div class="card" style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f7fafc; padding-bottom: 15px;">
                    <div>
                        <h3 style="font-size: 18px; font-weight: 700; color: #2d3748;">
                            Ressource : {{ $discussion->ressource->nom }}
                        </h3>
                        <p style="font-size: 14px; color: #718096; margin-top: 5px;">
                            Créée par {{ $discussion->createur->nom ?? 'N/A' }} • {{ $discussion->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <span style="padding: 5px 15px; background: #ebf8ff; color: #4299e1; border-radius: 20px; font-size: 12px; font-weight: 700;">
                        {{ $discussion->messages->count() }} messages
                    </span>
                </div>

                <div class="messages-list" style="display: flex; flex-direction: column; gap: 15px;">
                    @foreach($discussion->messages as $message)
                        <div style="padding: 15px; background: {{ $message->cache ? '#fff5f5' : '#f8fafc' }}; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                    <span style="font-weight: 700; font-size: 14px; color: #4a5568;">{{ $message->auteur->nom ?? 'Inconnu' }}</span>
                                    <span style="font-size: 11px; color: #a0aec0;">{{ $message->created_at->format('d/m H:i') }}</span>
                                    @if($message->cache)
                                        <span style="background: #feb2b2; color: #9b2c2c; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 800;">MASQUÉ</span>
                                    @endif
                                </div>
                                <p style="font-size: 14px; color: #2d3748; line-height: 1.5;">{{ $message->contenu }}</p>
                            </div>
                            
                            @if(!$message->cache)
                                <form action="{{ route('responsable.messages.hide', $message->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: #f56565; color: white; border: none; padding: 8px 15px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;" onclick="return confirm('Masquer ce message ?')">
                                        Masquer
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px; background: white; border-radius: 15px;">
                <div style="font-size: 64px; margin-bottom: 20px;"></div>
                <h3 style="font-size: 20px; font-weight: 700; color: #2d3748;">Aucune discussion active</h3>
                <p style="color: #718096; margin-top: 10px;">Les discussions apparaîtront ici lorsqu'un utilisateur en démarrera une.</p>
            </div>
        @endforelse
    </div>

    @if($discussions->hasPages())
        <div style="margin-top: 30px;">
            {{ $discussions->links() }}
        </div>
    @endif
</div>
@endsection
