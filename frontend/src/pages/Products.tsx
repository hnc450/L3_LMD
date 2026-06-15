import { useState } from "react";

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
}

const PRODUCTS: Product[] = [
  { id: 1, name: "Laptop Dell Inspiron 15", category: "Informatique", price: 85000, rating: 4.5, reviews: 32, seller: "TechShop Alger", badge: "Populaire", emoji: "💻" },
  { id: 2, name: "Samsung Galaxy A54", category: "Smartphones", price: 52000, rating: 4.3, reviews: 58, seller: "Mobile Center", emoji: "📱" },
  { id: 3, name: "Réfrigérateur Samsung 350L", category: "Électroménager", price: 78000, rating: 4.7, reviews: 21, seller: "Electro Oran", badge: "Nouveau", emoji: "🧊" },
  { id: 4, name: "SSD Kingston 1To NVMe", category: "Composants", price: 12500, rating: 4.8, reviews: 44, seller: "PC Parts DZ", badge: "Promo", emoji: "🔌" },
  { id: 5, name: "Écran LG 27\" 4K", category: "Périphériques", price: 65000, rating: 4.6, reviews: 17, seller: "TechShop Alger", emoji: "🖥️" },
  { id: 6, name: "Machine à laver LG 8kg", category: "Électroménager", price: 68000, rating: 4.4, reviews: 29, seller: "Electro Oran", emoji: "🫧" },
  { id: 7, name: "Processeur Ryzen 5 7600X", category: "Composants", price: 28000, rating: 4.9, reviews: 61, seller: "PC Parts DZ", badge: "Populaire", emoji: "⚙️" },
  { id: 8, name: "TV Sony 55\" OLED", category: "TV & Audio", price: 145000, rating: 4.8, reviews: 14, seller: "ElectroBest", badge: "Nouveau", emoji: "📺" },
];

const CATEGORIES = ["Tous", "Informatique", "Smartphones", "Électroménager", "Composants", "Périphériques", "TV & Audio"];
const SORT_OPTIONS = ["Pertinence", "Prix croissant", "Prix décroissant", "Mieux notés"];

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

export default function Products() {
  const [search, setSearch] = useState<string>("");
  const [category, setCategory] = useState<string>("Tous");
  const [sort, setSort] = useState<string>("Pertinence");
  const [liked, setLiked] = useState<Set<number>>(new Set());
  const [favorites, setFavorites] = useState<Set<number>>(new Set());
  const [reserved, setReserved] = useState<Set<number>>(new Set());

  const toggleLike = (id: number) =>
    setLiked((prev) => { const s = new Set(prev); s.has(id) ? s.delete(id) : s.add(id); return s; });

  const toggleFav = (id: number) =>
    setFavorites((prev) => { const s = new Set(prev); s.has(id) ? s.delete(id) : s.add(id); return s; });

  const handleReserve = (id: number) => {
    setReserved((prev) => { const s = new Set(prev); s.add(id); return s; });
    setTimeout(() => setReserved((prev) => { const s = new Set(prev); s.delete(id); return s; }), 2000);
    console.log("Reserve product:", id);
  };

  const filtered = PRODUCTS
    .filter((p) => category === "Tous" || p.category === category)
    .filter((p) => p.name.toLowerCase().includes(search.toLowerCase()) || p.seller.toLowerCase().includes(search.toLowerCase()))
    .sort((a, b) => {
      if (sort === "Prix croissant") return a.price - b.price;
      if (sort === "Prix décroissant") return b.price - a.price;
      if (sort === "Mieux notés") return b.rating - a.rating;
      return 0;
    });

  return (
    <div className="min-h-screen bg-gray-50">

      {/* ── HEADER ── */}
      <div className="bg-white border-b border-gray-100 shadow-sm">
        <div className="max-w-6xl mx-auto px-4 py-4">
          <div className="flex items-center justify-between mb-4">
            <div className="flex items-center gap-2">
              <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <span className="text-white text-sm">⚡</span>
              </div>
              <span className="font-bold text-blue-700 text-lg">TechLocal</span>
            </div>
            <div className="flex items-center gap-2">
              <button className="relative p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                {favorites.size > 0 && (
                  <span className="absolute -top-0.5 -right-0.5 w-4 h-4 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center">{favorites.size}</span>
                )}
              </button>
            </div>
          </div>

          {/* Barre de recherche */}
          <div className="flex gap-3">
            <div className="relative flex-1">
              <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                </svg>
              </span>
              <input
                type="text"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder="Rechercher un appareil, une marque, un vendeur..."
                className="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white"
              />
            </div>
            {/* Tri */}
            <select
              value={sort}
              onChange={(e) => setSort(e.target.value)}
              className="px-3 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            >
              {SORT_OPTIONS.map((o) => <option key={o}>{o}</option>)}
            </select>
          </div>
        </div>
      </div>

      <div className="max-w-6xl mx-auto px-4 py-6">

        {/* ── FILTRES CATÉGORIES ── */}
        <div className="flex gap-2 overflow-x-auto pb-2 mb-6 scrollbar-hide">
          {CATEGORIES.map((cat) => (
            <button
              key={cat}
              onClick={() => setCategory(cat)}
              className={`whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium transition-colors border ${
                category === cat
                  ? "bg-blue-600 text-white border-blue-600 shadow-sm"
                  : "bg-white text-gray-600 border-gray-200 hover:border-blue-300 hover:text-blue-600"
              }`}
            >
              {cat}
            </button>
          ))}
        </div>

        {/* Résultat count */}
        <p className="text-sm text-gray-500 mb-4">
          <span className="font-semibold text-gray-700">{filtered.length}</span> produit{filtered.length !== 1 ? "s" : ""} trouvé{filtered.length !== 1 ? "s" : ""}
          {category !== "Tous" && <span className="text-blue-600"> dans <strong>{category}</strong></span>}
          {search && <span> pour <strong>"{search}"</strong></span>}
        </p>

        {/* ── GRILLE PRODUITS ── */}
        {filtered.length === 0 ? (
          <div className="text-center py-20">
            <span className="text-5xl mb-4 block">🔍</span>
            <p className="text-gray-500 font-medium">Aucun produit trouvé</p>
            <p className="text-gray-400 text-sm mt-1">Essayez d'autres mots-clés ou catégories</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            {filtered.map((product) => (
              <div key={product.id} className="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">

                {/* Image / Emoji zone */}
                <div className="relative bg-gradient-to-br from-blue-50 to-blue-100 h-44 flex items-center justify-center">
                  <span className="text-6xl">{product.emoji}</span>

                  {/* Badge */}
                  {product.badge && (
                    <span className={`absolute top-3 left-3 text-xs font-semibold px-2 py-0.5 rounded-full ${
                      product.badge === "Promo" ? "bg-red-100 text-red-600" :
                      product.badge === "Nouveau" ? "bg-green-100 text-green-600" :
                      "bg-blue-100 text-blue-600"
                    }`}>
                      {product.badge}
                    </span>
                  )}

                  {/* Like + Favoris */}
                  <div className="absolute top-2 right-2 flex flex-col gap-1.5">
                    <button
                      onClick={() => toggleLike(product.id)}
                      className={`w-8 h-8 rounded-xl flex items-center justify-center transition-colors shadow-sm ${
                        liked.has(product.id) ? "bg-red-500 text-white" : "bg-white text-gray-400 hover:text-red-500"
                      }`}
                    >
                      <svg className="w-4 h-4" fill={liked.has(product.id) ? "currentColor" : "none"} stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                      </svg>
                    </button>
                    <button
                      onClick={() => toggleFav(product.id)}
                      className={`w-8 h-8 rounded-xl flex items-center justify-center transition-colors shadow-sm ${
                        favorites.has(product.id) ? "bg-blue-600 text-white" : "bg-white text-gray-400 hover:text-blue-600"
                      }`}
                    >
                      <svg className="w-4 h-4" fill={favorites.has(product.id) ? "currentColor" : "none"} stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                      </svg>
                    </button>
                  </div>
                </div>

                {/* Infos */}
                <div className="p-4">
                  <span className="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">{product.category}</span>
                  <h3 className="font-semibold text-gray-800 mt-2 mb-1 text-sm leading-snug line-clamp-2">{product.name}</h3>

                  <div className="flex items-center gap-1.5 mb-1">
                    <StarRating rating={product.rating} />
                    <span className="text-xs text-gray-500">{product.rating} ({product.reviews})</span>
                  </div>

                  <p className="text-xs text-gray-400 mb-3 flex items-center gap-1">
                    <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {product.seller}
                  </p>

                  <div className="flex items-center justify-between">
                    <p className="text-blue-700 font-bold text-base">
                      {product.price.toLocaleString("fr-DZ")} <span className="text-xs font-normal text-gray-500">DA</span>
                    </p>
                    <button
                      onClick={() => handleReserve(product.id)}
                      className={`flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-xl transition-all ${
                        reserved.has(product.id)
                          ? "bg-green-500 text-white"
                          : "bg-blue-600 hover:bg-blue-700 text-white shadow-sm shadow-blue-200"
                      }`}
                    >
                      {reserved.has(product.id) ? (
                        <>
                          <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                          </svg>
                          Réservé !
                        </>
                      ) : (
                        <>
                          <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
      </div>
    </div>
  );
}
