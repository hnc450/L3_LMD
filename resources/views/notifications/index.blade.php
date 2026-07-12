@extends('base.user')

@section('title', 'Notifications')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
            <p class="text-gray-500">Suivez les mises à jour de vos plaintes</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('notifications.index') }}" class="px-4 py-2 rounded-lg text-sm {{ !request('filter') ? 'bg-blue-700 text-white' : 'border' }}">Toutes</a>
            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" class="px-4 py-2 rounded-lg text-sm {{ request('filter')==='unread' ? 'bg-blue-700 text-white' : 'border' }}">Non lues</a>
            <a href="{{ route('notifications.index', ['filter' => 'read']) }}" class="px-4 py-2 rounded-lg text-sm {{ request('filter')==='read' ? 'bg-blue-700 text-white' : 'border' }}">Lues</a>
        </div>
    </div>

    <div class="space-y-3">
        @forelse($notifications ?? [] as $notification)
        <div class="bg-white rounded-2xl shadow p-5 {{ $notification->status === 'sent' ? 'border-l-4 border-blue-600' : 'opacity-80' }}">
            <div class="flex justify-between items-start gap-4">
                <div>
                    <p class="text-gray-800">{{ $notification->content }}</p>
                    @if($notification->plainte)
                    <a href="{{ route('complaints.show', $notification->id_plainte) }}" class="text-blue-600 text-sm mt-2 inline-block hover:underline">
                        Voir la plainte {{ $notification->plainte->code_suivi }}
                    </a>
                    @endif
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                    @if($notification->status === 'sent')
                    <span class="inline-block mt-1 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full">Nouveau</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow p-12 text-center text-gray-500">
            <i class="fa-solid fa-bell text-4xl text-gray-300 mb-3"></i>
            <p>Aucune notification pour le moment</p>
        </div>
        @endforelse
    </div>

    @if(isset($notifications) && $notifications->count())
    <form method="POST" action="{{ route('notifications.mark-read') }}" class="text-center">
        @csrf
        <button type="submit" class="bg-blue-700 text-white px-6 py-3 rounded-xl hover:bg-blue-800">
            Tout marquer comme lu
        </button>
    </form>
    @endif

    @if(isset($notifications) && $notifications->hasPages())
    <div>{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
