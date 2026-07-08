@extends('base.user')

@section('title', 'Notifications - Plateforme de Plaintes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Notifications</h1>
            <p class="text-gray-600 mt-2">Suivez les mises à jour de vos plaintes</p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
            <div class="flex gap-4 flex-wrap">
                <button class="px-4 py-2 bg-royal-blue-600 text-white rounded-lg hover:bg-royal-blue-700 transition-colors">
                    Toutes
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Non lues
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Lues
                </button>
            </div>
        </div>
        
        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse($notifications ?? [] as $notification)
            <div class="bg-white rounded-lg shadow-lg p-6 {{ $notification->read_at ? 'opacity-75' : 'border-l-4 border-royal-blue-600' }}">
                <div class="flex items-start">
                    <div class="w-12 h-12 {{ $notification->read_at ? 'bg-gray-100' : 'bg-royal-blue-100' }} rounded-full flex items-center justify-center mr-4">
                        @switch($notification->type ?? 'info')
                            @case('complaint_created')
                                <span class="text-2xl">📝</span>
                                @break
                            @case('status_updated')
                                <span class="text-2xl">🔄</span>
                                @break
                            @case('response_added')
                                <span class="text-2xl">💬</span>
                                @break
                            @case('complaint_resolved')
                                <span class="text-2xl">✅</span>
                                @break
                            @default
                                <span class="text-2xl">🔔</span>
                        @endswitch
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $notification->title ?? 'Notification' }}</h3>
                                <p class="text-gray-600 mt-1">{{ $notification->message ?? '' }}</p>
                                @if($notification->complaint_id)
                                <a href="{{ route('complaint.show', $notification->complaint_id) }}" class="text-royal-blue-600 hover:text-royal-blue-900 text-sm font-medium mt-2 inline-block">
                                    Voir la plainte #{{ $notification->complaint_id }}
                                </a>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">{{ $notification->created_at ? $notification->created_at->diffForHumans() : 'N/A' }}</p>
                                @if(!$notification->read_at)
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full bg-royal-blue-100 text-royal-blue-800">
                                    Nouveau
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <span class="text-6xl">🔔</span>
                <p class="text-xl text-gray-600 mt-4">Aucune notification</p>
                <p class="text-gray-500 mt-2">Vous serez notifié lors des mises à jour de vos plaintes</p>
            </div>
            @endforelse
        </div>
        
        <!-- Mark all as read button -->
        @if(isset($notifications) && $notifications->count() > 0)
        <div class="mt-6 text-center">
            <form method="POST" action="{{ route('notifications.mark-read') }}">
                @csrf
                <button type="submit" class="bg-royal-blue-600 text-white px-6 py-3 rounded-lg hover:bg-royal-blue-700 transition-colors">
                    Tout marquer comme lu
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
