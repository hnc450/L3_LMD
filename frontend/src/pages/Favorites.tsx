import { useState } from "react";
import { useNavigate } from "react-router-dom";

interface Product {
  id: number;
  name: string;
  category: string;
  price: number;
  rating: number;
  reviews: number;
  seller: string;
  badge?: string;
  emoji: string;
  savedAt: string;
}

const FAVORITES: Product[] = [
  { id: 1, name: "Laptop Dell Inspiron 15", category: "Informatique", price: 85000, rating: 4.5, reviews: 32, seller: "TechShop Alger", badge: "Populaire", emoji: "💻", savedAt: "2026-06-15" },
  { id: 3, name: "Réfrigérateur Samsung 350L", category: "Électroménager", price: 78000, rating: 4.7, reviews: 21, seller: "Electro Oran", badge: "Nouveau", emoji: "🧊", savedAt: "2026-06-14" },
  { id: 4, name: "SSD Kingston 1To NVMe", category: "Composants", price: 12500, rating: 4.8, reviews: 44, seller: "PC Parts DZ", badge: "Promo", emoji: "🔌", savedAt: "2026-06-12" },
  { id: 7, name: "Processeur Ryzen 5 7600X", category: "Composants", price: 28000, rating: 4.9, reviews: 61, seller: "PC Parts DZ", badge: "Populaire", emoji: "⚙️", savedAt: "2026-06-10" },
];

function StarRating({ rating }: { rating: number }) {
  return (
    <div className="flex items-center gap-0.5">
      {[1, 2, 3, 4, 5].map((s) => (
        <svg key={s} className={`w-3.5 h-3.5 ${s <= Math.round(rating) ? "text-yellow-400" : "text-gray-200"}`} fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
        </svg>
      ))}
    </div>
  );
}

export default function Favorites() {
  const navigate = useNavigate();
  const [favorites, setFavorites] = useState<Product[]>(FAVORITES);
  const [reserved, setReserved] = useState<Set<number>>(new Set());

  const removeFavorite = (id: number) => {
    setFavorites((prev) => prev.filter((p) => p.id !== id));
  };

  const handleReserve = (id: number) => {
    setReserved((prev) => { const s = new Set(prev); s.add(id); return s; });
    setTimeout(() => setReserved((prev) => { const s = new Set(prev); s.delete(id); return s; }), 2000);
  };

  const totalValue = favorites.reduce((sum, p) => sum + p.price, 0);

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">

      {/* ── HEADER ── */}
      <div className="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div className="max-w-5xl mx-auto px-4 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <button
                onClick={() => navigate("/products")}
                className="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors"
              >
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
              </button>
              <div>
                <h1 className="text-xl font-bold text-gray-800">Mes Favoris</h1>
                <p className="text-sm text-gray-500">{favorites.length} article{favorites.length !== 1 ? "s" : ""} enregistré{favorites.length !== 1 ? "s" : ""}</p>
              </div>
            </div>

            <div className="flex items-center gap-2">
              <div className="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-blue-50 rounded-lg">
                <span className="text-sm text-gray-600">Valeur totale:</span>
                <span className="font-bold text-blue-700">{totalValue.toLocaleString("fr-DZ")} DA</span>
              </div>
              <button
                onClick={() => navigate("/user")}
                className="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white hover:bg-blue-700 transition-colors"
              >
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-5xl mx-auto px-4 py-6">

        {/* Empty state */}
        {favorites.length === 0 ? (
          <div className="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-blue-50 rounded-full mb-6">
              <svg className="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
              </svg>
            </div>
            <h2 className="text-2xl font-bold text-gray-800 mb-2">Aucun favori</h2>
            <p className="text-gray-500 mb-6 max-w-sm mx-auto">Vous n'avez pas encore ajouté d'articles à vos favoris. Explorez nos produits pour en ajouter.</p>
            <button
              onClick={() => navigate("/products")}
              className="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-md shadow-blue-200"
            >
              Découvrir les produits
            </button>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            {favorites.map((product) => (
              <div key={product.id} className="bg-white rounded-2xl border border-gray-100 shadow-lg hover:shadow-xl transition-all overflow-hidden group">

                {/* Image */}
                <div className="relative bg-gradient-to-br from-blue-50 to-blue-100 h-48 flex items-center justify-center">
                  <span className="text-7xl">{product.emoji}</span>

                  {/* Badge */}
                  {product.badge && (
                    <span className={`absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full ${
                      product.badge === "Promo" ? "bg-red-100 text-red-600" :
                      product.badge === "Nouveau" ? "bg-green-100 text-green-600" :
                      "bg-blue-100 text-blue-600"
                    }`}>
                      {product.badge}
                    </span>
                  )}

                  {/* Remove button */}
                  <button
                    onClick={() => removeFavorite(product.id)}
                    className="absolute top-3 right-3 w-9 h-9 bg-white text-gray-400 hover:text-red-500 rounded-xl flex items-center justify-center shadow-sm transition-colors"
                    title="Retirer des favoris"
                  >
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>

                  {/* Quick actions overlay */}
                  <div className="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex justify-center gap-2">
                    <button
                      onClick={() => navigate("/products")}
                      className="px-3 py-1.5 bg-white text-gray-800 text-xs font-medium rounded-lg hover:bg-gray-100 transition-colors"
                    >
                      Voir le produit
                    </button>
                  </div>
                </div>

                {/* Content */}
                <div className="p-5">
                  <div className="flex items-start justify-between gap-2 mb-2">
                    <span className="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-1 rounded-full">{product.category}</span>
                    <span className="text-xs text-gray-400">{product.savedAt}</span>
                  </div>

                  <h3 className="font-semibold text-gray-800 mb-2 text-base leading-snug line-clamp-2">{product.name}</h3>

                  <div className="flex items-center gap-2 mb-3">
                    <StarRating rating={product.rating} />
                    <span className="text-xs text-gray-500">({product.reviews} avis)</span>
                  </div>

                  <div className="flex items-center gap-1.5 text-sm text-gray-500 mb-4">
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {product.seller}
                  </div>

                  <div className="flex items-center justify-between pt-3 border-t border-gray-100">
                    <div>
                      <p className="text-xl font-bold text-blue-700">
                        {product.price.toLocaleString("fr-DZ")} <span className="text-sm font-normal text-gray-500">DA</span>
                      </p>
                    </div>
                    <button
                      onClick={() => handleReserve(product.id)}
                      className={`flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-xl transition-all ${
                        reserved.has(product.id)
                          ? "bg-green-500 text-white"
                          : "bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-200"
                      }`}
                    >
                      {reserved.has(product.id) ? (
                        <>
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                          </svg>
                          Réservé !
                        </>
                      ) : (
                        <>
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                          Réserver
                        </>
                      )}
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}

        {/* Mobile total */}
        {favorites.length > 0 && (
          <div className="sm:hidden mt-6 bg-white rounded-xl p-4 shadow-lg border border-gray-100">
            <div className="flex items-center justify-between">
              <span className="text-gray-600">Valeur totale:</span>
              <span className="font-bold text-blue-700 text-lg">{totalValue.toLocaleString("fr-DZ")} DA</span>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}