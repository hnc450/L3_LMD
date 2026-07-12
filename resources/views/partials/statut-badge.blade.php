@php use App\Support\PlainteStatut; @endphp
<span class="px-3 py-1 text-xs font-semibold rounded-full {{ PlainteStatut::badgeClass($statut) }}">
    {{ PlainteStatut::icon($statut) }} {{ $statut }}
</span>
