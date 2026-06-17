import { useState } from "react";

type Tab = "overview" | "products" | "reservations" | "reviews";

const STATS = [
  { label: "Produits actifs", value: "48", change: "+3", positive: true, icon: "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4", color: "blue" },
  { label: "Réservations", value: "126", change: "+18%", positive: true, icon: "M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z", color: "green" },
  { label: "Revenu du mois", value: "245 000 DA", change: "+12%", positive: true, icon: "M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1", color: "purple" },
  { label: "Note moyenne", value: "4.7 / 5", change: "+0.2", positive: true, icon: "M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z", color: "orange" },
];

const SECONDARY_STATS = [
  { label: "Vues totales du mois", value: "8 942" },
  { label: "Taux de conversion", value: "14.1 %" },
  { label: "Produits en rupture", value: "3" },
  { label: "Réservations en attente", value: "9" },
  { label: "Favoris reçus", value: "412" },
  { label: "Commandes annulées", value: "5" },
];

const MY_PRODUCTS = [
  { id: 1, name: "Laptop Dell Inspiron 15", price: "85 000 DA", stock: 12, views: 1240, reservations: 32, status: "Actif", emoji: "💻" },
  { id: 2, name: "SSD Kingston 1To NVMe", price: "12 500 DA", stock: 0, views: 890, reservations: 44, status: "Rupture", emoji: "🔌" },
  { id: 3, name: "Écran LG 27\" 4K", price: "65 000 DA", stock: 8, views: 567, reservations: 17, status: "Actif", emoji: "🖥️" },
  { id: 4, name: "Processeur Ryzen 5 7600X", price: "28 000 DA", stock: 5, views: 1530, reservations: 61, status: "Actif", emoji: "⚙️" },
];

const RESERVATIONS = [
  { id: 1, client: "Amine Benali", product: "Laptop Dell Inspiron 15", date: "2026-06-17", status: "En attente" },
  { id: 2, client: "Sara Kaci", product: "Écran LG 27\" 4K", date: "2026-06-16", status: "Confirmée" },
  { id: 3, client: "Yacine Mansouri", product: "Processeur Ryzen 5 7600X", date: "2026-06-15", status: "Confirmée" },
  { id: 4, client: "Lina Hadj", product: "SSD Kingston 1To NVMe", date: "2026-06-14", status: "Annulée" },
];

const REVIEWS = [
  { id: 1, client: "Amine B.", product: "Laptop Dell Inspiron 15", rating: 5, comment: "Excellent produit, livraison rapide !", date: "2026-06-16" },
  { id: 2, client: "Sara K.", product: "Écran LG 27\" 4K", rating: 4, comment: "Très bon écran, conforme à la description.", date: "2026-06-14" },
  { id: 3, client: "Karim O.", product: "Processeur Ryzen 5", rating: 5, comment: "Parfait, je recommande ce vendeur.", date: "2026-06-12" },
];

const colorMap: Record<string, string> = {
  blue: "bg-blue-100 text-blue-600",
  green: "bg-green-100 text-green-600",
  purple: "bg-purple-100 text-purple-600",
  orange: "bg-orange-100 text-orange-600",
};

function statusBadge(status: string) {
  if (status === "Actif" || status === "Confirmée") return "bg-green-100 text-green-700";
  if (status === "Rupture" || status === "Annulée") return "bg-red-100 text-red-700";
  return "bg-yellow-100 text-yellow-700";
}

function Stars({ rating }: { rating: number }) {
  return (
    <div className="flex gap-0.5">
      {[1, 2, 3, 4, 5].map((s) => (
        <svg key={s} className={`w-4 h-4 ${s <= rating ? "text-yellow-400" : "text-gray-200"}`} fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
        </svg>
      ))}
    </div>
  );
}

export default function Seller() {
  const [activeTab, setActiveTab] = useState<Tab>("overview");

  const TABS: { id: Tab; label: string; icon: string }[] = [
    { id: "overview", label: "Vue d'ensemble", icon: "M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" },
    { id: "products", label: "Mes produits", icon: "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" },
    { id: "reservations", label: "Réservations", icon: "M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" },
    { id: "reviews", label: "Avis clients", icon: "M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" },
  ];

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
      <div className="max-w-6xl mx-auto px-4 py-6">

        {/* Title */}
        <div className="flex items-center justify-between mb-6">
          <div className="flex items-center gap-3">
            <div className="w-11 h-11 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-200">
              <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <div>
              <h1 className="text-2xl font-bold text-gray-800">Espace Vendeur</h1>
              <p className="text-sm text-gray-500">TechShop Alger — Gérez votre boutique</p>
            </div>
          </div>
          <button className="hidden sm:flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un produit
          </button>
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

            {/* Recent reservations */}
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
              <div className="p-6 border-b border-gray-100">
                <h2 className="text-lg font-bold text-gray-800">Réservations récentes</h2>
              </div>
              <div className="divide-y divide-gray-100">
                {RESERVATIONS.slice(0, 3).map((r) => (
                  <div key={r.id} className="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div>
                      <p className="font-medium text-gray-800">{r.product}</p>
                      <p className="text-sm text-gray-500">{r.client} • {r.date}</p>
                    </div>
                    <span className={`px-2.5 py-1 rounded-full text-xs font-medium ${statusBadge(r.status)}`}>{r.status}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        )}

        {/* PRODUCTS */}
        {activeTab === "products" && (
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div className="p-6 border-b border-gray-100 flex items-center justify-between">
              <h2 className="text-lg font-bold text-gray-800">Mes produits ({MY_PRODUCTS.length})</h2>
              <button className="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-colors">
                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                </svg>
                Nouveau
              </button>
            </div>
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="bg-gray-50 text-gray-500 text-left">
                  <tr>
                    <th className="px-6 py-3 font-medium">Produit</th>
                    <th className="px-6 py-3 font-medium">Prix</th>
                    <th className="px-6 py-3 font-medium">Stock</th>
                    <th className="px-6 py-3 font-medium">Vues</th>
                    <th className="px-6 py-3 font-medium">Réserv.</th>
                    <th className="px-6 py-3 font-medium">Statut</th>
                    <th className="px-6 py-3 font-medium text-right">Actions</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                  {MY_PRODUCTS.map((p) => (
                    <tr key={p.id} className="hover:bg-gray-50 transition-colors">
                      <td className="px-6 py-4">
                        <div className="flex items-center gap-3">
                          <span className="text-2xl">{p.emoji}</span>
                          <span className="font-medium text-gray-800">{p.name}</span>
                        </div>
                      </td>
                      <td className="px-6 py-4 font-semibold text-blue-700">{p.price}</td>
                      <td className="px-6 py-4 text-gray-600">{p.stock}</td>
                      <td className="px-6 py-4 text-gray-600">{p.views}</td>
                      <td className="px-6 py-4 text-gray-600">{p.reservations}</td>
                      <td className="px-6 py-4"><span className={`px-2 py-0.5 rounded-full text-xs font-medium ${statusBadge(p.status)}`}>{p.status}</span></td>
                      <td className="px-6 py-4 text-right">
                        <button className="text-blue-600 hover:underline text-xs font-medium mr-3">Modifier</button>
                        <button className="text-red-500 hover:underline text-xs font-medium">Supprimer</button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}

        {/* RESERVATIONS */}
        {activeTab === "reservations" && (
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div className="p-6 border-b border-gray-100">
              <h2 className="text-lg font-bold text-gray-800">Toutes les réservations</h2>
            </div>
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="bg-gray-50 text-gray-500 text-left">
                  <tr>
                    <th className="px-6 py-3 font-medium">Client</th>
                    <th className="px-6 py-3 font-medium">Produit</th>
                    <th className="px-6 py-3 font-medium">Date</th>
                    <th className="px-6 py-3 font-medium">Statut</th>
                    <th className="px-6 py-3 font-medium text-right">Actions</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                  {RESERVATIONS.map((r) => (
                    <tr key={r.id} className="hover:bg-gray-50 transition-colors">
                      <td className="px-6 py-4 font-medium text-gray-800">{r.client}</td>
                      <td className="px-6 py-4 text-gray-600">{r.product}</td>
                      <td className="px-6 py-4 text-gray-400">{r.date}</td>
                      <td className="px-6 py-4"><span className={`px-2 py-0.5 rounded-full text-xs font-medium ${statusBadge(r.status)}`}>{r.status}</span></td>
                      <td className="px-6 py-4 text-right">
                        {r.status === "En attente" ? (
                          <>
                            <button className="text-green-600 hover:underline text-xs font-medium mr-3">Confirmer</button>
                            <button className="text-red-500 hover:underline text-xs font-medium">Refuser</button>
                          </>
                        ) : (
                          <button className="text-blue-600 hover:underline text-xs font-medium">Détails</button>
                        )}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}

        {/* REVIEWS */}
        {activeTab === "reviews" && (
          <div className="space-y-4">
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center gap-6">
              <div className="text-center">
                <p className="text-4xl font-bold text-blue-700">4.7</p>
                <Stars rating={5} />
                <p className="text-sm text-gray-500 mt-1">412 avis</p>
              </div>
              <div className="flex-1 space-y-1.5">
                {[5, 4, 3, 2, 1].map((star) => (
                  <div key={star} className="flex items-center gap-2 text-sm">
                    <span className="w-3 text-gray-500">{star}</span>
                    <div className="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                      <div className="h-full bg-yellow-400 rounded-full" style={{ width: `${star === 5 ? 70 : star === 4 ? 20 : star === 3 ? 6 : 2}%` }} />
                    </div>
                    <span className="w-10 text-right text-gray-400 text-xs">{star === 5 ? 288 : star === 4 ? 82 : star === 3 ? 25 : 8}</span>
                  </div>
                ))}
              </div>
            </div>

            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 divide-y divide-gray-100">
              {REVIEWS.map((rev) => (
                <div key={rev.id} className="p-5">
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-sm font-medium">
                        {rev.client.charAt(0)}
                      </div>
                      <div>
                        <p className="font-medium text-gray-800">{rev.client}</p>
                        <p className="text-xs text-gray-400">{rev.product} • {rev.date}</p>
                      </div>
                    </div>
                    <Stars rating={rev.rating} />
                  </div>
                  <p className="text-sm text-gray-600 ml-12">{rev.comment}</p>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
