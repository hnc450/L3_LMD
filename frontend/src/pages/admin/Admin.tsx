import { useState } from "react";

type Tab = "overview" | "users" | "sellers" | "products" | "reservations";

interface StatCard {
  label: string;
  value: string;
  change: string;
  positive: boolean;
  icon: string;
  color: string;
}

const STATS: StatCard[] = [
  { label: "Utilisateurs totaux", value: "12 458", change: "+8.2%", positive: true, icon: "M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z", color: "blue" },
  { label: "Vendeurs actifs", value: "342", change: "+12.5%", positive: true, icon: "M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z", color: "green" },
  { label: "Produits publiés", value: "8 921", change: "+5.1%", positive: true, icon: "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4", color: "purple" },
  { label: "Réservations", value: "3 156", change: "-2.3%", positive: false, icon: "M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z", color: "orange" },
];

const SECONDARY_STATS = [
  { label: "Revenu total (commission)", value: "1 245 800 DA" },
  { label: "Nouveaux utilisateurs (ce mois)", value: "1 024" },
  { label: "Produits en attente de validation", value: "47" },
  { label: "Vendeurs en attente", value: "12" },
  { label: "Signalements à traiter", value: "8" },
  { label: "Taux de conversion", value: "24.6 %" },
];

const RECENT_USERS = [
  { id: 1, name: "Amine Benali", email: "amine.benali@email.com", role: "Client", status: "Actif", date: "2026-06-17" },
  { id: 2, name: "Sara Kaci", email: "sara.kaci@email.com", role: "Vendeur", status: "Actif", date: "2026-06-16" },
  { id: 3, name: "Yacine Mansouri", email: "yacine.m@email.com", role: "Client", status: "Suspendu", date: "2026-06-15" },
  { id: 4, name: "Lina Hadj", email: "lina.hadj@email.com", role: "Vendeur", status: "En attente", date: "2026-06-14" },
  { id: 5, name: "Karim Ould", email: "karim.ould@email.com", role: "Client", status: "Actif", date: "2026-06-13" },
];

const PENDING_PRODUCTS = [
  { id: 1, name: "MacBook Pro M3 14\"", seller: "TechShop Alger", price: "385 000 DA", category: "Informatique" },
  { id: 2, name: "iPhone 15 Pro Max", seller: "Mobile Center", price: "295 000 DA", category: "Smartphones" },
  { id: 3, name: "Climatiseur Samsung 12000", seller: "Electro Oran", price: "92 000 DA", category: "Électroménager" },
];

const colorMap: Record<string, string> = {
  blue: "bg-blue-100 text-blue-600",
  green: "bg-green-100 text-green-600",
  purple: "bg-purple-100 text-purple-600",
  orange: "bg-orange-100 text-orange-600",
};

function statusBadge(status: string) {
  if (status === "Actif") return "bg-green-100 text-green-700";
  if (status === "Suspendu") return "bg-red-100 text-red-700";
  return "bg-yellow-100 text-yellow-700";
}

export default function Admin() {
  const [activeTab, setActiveTab] = useState<Tab>("overview");

  const TABS: { id: Tab; label: string; icon: string }[] = [
    { id: "overview", label: "Vue d'ensemble", icon: "M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" },
    { id: "users", label: "Utilisateurs", icon: "M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z" },
    { id: "sellers", label: "Vendeurs", icon: "M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" },
    { id: "products", label: "Produits", icon: "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" },
    { id: "reservations", label: "Réservations", icon: "M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" },
  ];

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
      <div className="max-w-6xl mx-auto px-4 py-6">

        {/* Title */}
        <div className="flex items-center justify-between mb-6">
          <div className="flex items-center gap-3">
            <div className="w-11 h-11 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-200">
              <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <h1 className="text-2xl font-bold text-gray-800">Tableau de bord Admin</h1>
              <p className="text-sm text-gray-500">Gestion globale de la plateforme TechLocal</p>
            </div>
          </div>
          <span className="hidden sm:inline-block px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg">Administrateur</span>
        </div>

        {/* Tabs */}
        <div className="flex gap-2 overflow-x-auto pb-2 mb-6">
          {TABS.map((tab) => (
            <button
              key={tab.id}
              onClick={() => setActiveTab(tab.id)}
              className={`whitespace-nowrap flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors ${
                activeTab === tab.id
                  ? "bg-blue-600 text-white shadow-md"
                  : "bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600 border border-gray-100"
              }`}
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d={tab.icon} />
              </svg>
              {tab.label}
            </button>
          ))}
        </div>

        {/* OVERVIEW */}
        {activeTab === "overview" && (
          <div className="space-y-6">
            {/* Main stat cards */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
              {STATS.map((stat) => (
                <div key={stat.label} className="bg-white rounded-2xl shadow-lg border border-gray-100 p-5">
                  <div className="flex items-center justify-between mb-3">
                    <div className={`w-11 h-11 rounded-xl flex items-center justify-center ${colorMap[stat.color]}`}>
                      <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d={stat.icon} />
                      </svg>
                    </div>
                    <span className={`text-xs font-semibold px-2 py-1 rounded-full ${stat.positive ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"}`}>
                      {stat.change}
                    </span>
                  </div>
                  <p className="text-2xl font-bold text-gray-800">{stat.value}</p>
                  <p className="text-sm text-gray-500">{stat.label}</p>
                </div>
              ))}
            </div>

            {/* Secondary stats */}
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
              <h2 className="text-lg font-bold text-gray-800 mb-4">Statistiques détaillées</h2>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {SECONDARY_STATS.map((s) => (
                  <div key={s.label} className="p-4 bg-blue-50 rounded-xl">
                    <p className="text-xl font-bold text-blue-700">{s.value}</p>
                    <p className="text-sm text-gray-600">{s.label}</p>
                  </div>
                ))}
              </div>
            </div>

            {/* Pending validation */}
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
              <div className="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 className="text-lg font-bold text-gray-800">Produits en attente de validation</h2>
                <span className="px-2.5 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">{PENDING_PRODUCTS.length} en attente</span>
              </div>
              <div className="divide-y divide-gray-100">
                {PENDING_PRODUCTS.map((p) => (
                  <div key={p.id} className="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div>
                      <p className="font-medium text-gray-800">{p.name}</p>
                      <p className="text-sm text-gray-500">{p.seller} • {p.category} • {p.price}</p>
                    </div>
                    <div className="flex items-center gap-2">
                      <button className="px-3 py-1.5 bg-green-50 text-green-600 text-sm font-medium rounded-lg hover:bg-green-100 transition-colors">Valider</button>
                      <button className="px-3 py-1.5 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors">Refuser</button>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        )}

        {/* USERS */}
        {(activeTab === "users" || activeTab === "sellers") && (
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div className="p-6 border-b border-gray-100 flex items-center justify-between">
              <h2 className="text-lg font-bold text-gray-800">
                {activeTab === "users" ? "Gestion des utilisateurs" : "Gestion des vendeurs"}
              </h2>
              <div className="relative">
                <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                  </svg>
                </span>
                <input type="text" placeholder="Rechercher..." className="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
              </div>
            </div>
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="bg-gray-50 text-gray-500 text-left">
                  <tr>
                    <th className="px-6 py-3 font-medium">Nom</th>
                    <th className="px-6 py-3 font-medium">Email</th>
                    <th className="px-6 py-3 font-medium">Rôle</th>
                    <th className="px-6 py-3 font-medium">Statut</th>
                    <th className="px-6 py-3 font-medium">Inscription</th>
                    <th className="px-6 py-3 font-medium text-right">Actions</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                  {RECENT_USERS
                    .filter((u) => activeTab === "users" ? true : u.role === "Vendeur")
                    .map((u) => (
                    <tr key={u.id} className="hover:bg-gray-50 transition-colors">
                      <td className="px-6 py-4 font-medium text-gray-800">{u.name}</td>
                      <td className="px-6 py-4 text-gray-500">{u.email}</td>
                      <td className="px-6 py-4"><span className="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-xs">{u.role}</span></td>
                      <td className="px-6 py-4"><span className={`px-2 py-0.5 rounded-full text-xs font-medium ${statusBadge(u.status)}`}>{u.status}</span></td>
                      <td className="px-6 py-4 text-gray-400">{u.date}</td>
                      <td className="px-6 py-4 text-right">
                        <button className="text-blue-600 hover:underline text-xs font-medium mr-3">Voir</button>
                        <button className="text-red-500 hover:underline text-xs font-medium">Suspendre</button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}

        {/* PRODUCTS */}
        {activeTab === "products" && (
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div className="p-6 border-b border-gray-100">
              <h2 className="text-lg font-bold text-gray-800">Tous les produits</h2>
              <p className="text-sm text-gray-500">8 921 produits publiés sur la plateforme</p>
            </div>
            <div className="divide-y divide-gray-100">
              {PENDING_PRODUCTS.map((p) => (
                <div key={p.id} className="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                  <div>
                    <p className="font-medium text-gray-800">{p.name}</p>
                    <p className="text-sm text-gray-500">{p.seller} • {p.category}</p>
                  </div>
                  <div className="flex items-center gap-4">
                    <span className="font-bold text-blue-700">{p.price}</span>
                    <button className="text-red-500 hover:underline text-xs font-medium">Supprimer</button>
                  </div>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* RESERVATIONS */}
        {activeTab === "reservations" && (
          <div className="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
              <p className="text-3xl font-bold text-blue-700">3 156</p>
              <p className="text-sm text-gray-500 mt-1">Réservations totales</p>
            </div>
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
              <p className="text-3xl font-bold text-green-600">2 489</p>
              <p className="text-sm text-gray-500 mt-1">Confirmées</p>
            </div>
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
              <p className="text-3xl font-bold text-orange-500">667</p>
              <p className="text-sm text-gray-500 mt-1">En attente</p>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
