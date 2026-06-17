import { useState } from "react";
import { useNavigate } from "react-router-dom";

const categories = [
  { icon: "💻", label: "Informatique" },
  { icon: "📱", label: "Smartphones" },
  { icon: "🖨️", label: "Périphériques" },
  { icon: "�", label: "Électroménager" },
  { icon: "🔌", label: "Composants" },
  { icon: "📺", label: "TV & Audio" },
];

const features = [
  {
    icon: (
      <svg className="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
      </svg>
    ),
    title: "Recherche avancée",
    desc: "Trouvez rapidement vos appareils par catégorie, marque, prix ou vendeur.",
  },
  {
    icon: (
      <svg className="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
      </svg>
    ),
    title: "Réservation en ligne",
    desc: "Réservez vos appareils en quelques clics et recevez un ticket de confirmation par e-mail.",
  },
  {
    icon: (
      <svg className="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    ),
    title: "Vendeurs locaux vérifiés",
    desc: "Achetez auprès de vendeurs de confiance près de chez vous, sans intermédiaire.",
  },
  {
    icon: (
      <svg className="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
      </svg>
    ),
    title: "Avis & Notations",
    desc: "Consultez les avis des acheteurs et notez la qualité des produits et vendeurs.",
  },
];

const stats = [
  { value: "800+", label: "Vendeurs locaux" },
  { value: "15k+", label: "Appareils disponibles" },
  { value: "30k+", label: "Réservations effectuées" },
  { value: "4.7★", label: "Note moyenne" },
];

export default function Home() {
  const [search, setSearch] = useState<string>("");
  const navigate = useNavigate();

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    console.log("Search:", search);
  };

  return (
    <div className="min-h-screen bg-white font-sans">

      {/* ── NAVBAR ──
      <nav className="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div className="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
          <div className="flex items-center gap-2">
            <div className="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
              <span className="text-white text-lg">⚡</span>
            </div>
            <span className="text-lg font-bold text-blue-700 tracking-tight">TechLocal</span>
          </div>
          <div className="hidden md:flex items-center gap-6 text-sm text-gray-600">
            <a href="#categories" className="hover:text-blue-600 transition-colors">Catégories</a>
            <a href="#features" className="hover:text-blue-600 transition-colors">Fonctionnalités</a>
            <a href="#stats" className="hover:text-blue-600 transition-colors">Chiffres</a>
          </div>
          <div className="flex items-center gap-3">
            <button
              onClick={() => navigate("/login")}
              className="text-sm text-blue-600 font-medium hover:underline"
            >
              Se connecter
            </button>
            <button
              onClick={() => navigate("/login")}
              className="text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-xl transition-colors shadow-sm"
            >
              S'inscrire
            </button>
          </div>
        </div>
      </nav> */}

      {/* ── HERO ── */}
      <section className="bg-gradient-to-br from-blue-50 to-blue-100 py-20 px-4">
        <div className="max-w-3xl mx-auto text-center">
          <span className="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">
            Électroménager • Informatique • Composants
          </span>
          <h1 className="text-4xl md:text-5xl font-extrabold text-gray-800 leading-tight mb-4">
            Trouvez et réservez vos{" "}
            <span className="text-blue-600">appareils électroniques</span>
          </h1>
          <p className="text-gray-500 text-lg mb-8 max-w-xl mx-auto">
            Achetez des électroménagers, composants informatiques et smartphones auprès de vendeurs locaux de confiance.
          </p>

          {/* Barre de recherche */}
          <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
            <div className="relative flex-1">
              <span className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.8} d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                </svg>
              </span>
              <input
                type="text"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder="Rechercher un appareil, une marque, un vendeur..."
                className="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition"
              />
            </div>
            <button
              type="submit"
              className="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-md shadow-blue-200 whitespace-nowrap"
            >
              Rechercher
            </button>
          </form>
        </div>
      </section>

      {/* ── STATS ── */}
      <section id="stats" className="bg-blue-600 py-10 px-4">
        <div className="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          {stats.map((s) => (
            <div key={s.label}>
              <p className="text-3xl font-extrabold text-white">{s.value}</p>
              <p className="text-blue-100 text-sm mt-1">{s.label}</p>
            </div>
          ))}
        </div>
      </section>

      {/* ── CATÉGORIES ── */}
      <section id="categories" className="py-16 px-4 bg-white">
        <div className="max-w-4xl mx-auto">
          <h2 className="text-2xl font-bold text-gray-800 text-center mb-2">Explorez par catégorie</h2>
          <p className="text-gray-500 text-center text-sm mb-10">Parcourez nos appareils classés par type</p>
          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            {categories.map((cat) => (
              <button
                key={cat.label}
                className="flex flex-col items-center gap-2 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-all group shadow-sm"
              >
                <span className="text-3xl">{cat.icon}</span>
                <span className="text-xs font-medium text-gray-600 group-hover:text-blue-600 text-center">{cat.label}</span>
              </button>
            ))}
          </div>
        </div>
      </section>

      {/* ── FONCTIONNALITÉS ── */}
      <section id="features" className="py-16 px-4 bg-gradient-to-br from-blue-50 to-blue-100">
        <div className="max-w-4xl mx-auto">
          <h2 className="text-2xl font-bold text-gray-800 text-center mb-2">Pourquoi choisir TechLocal ?</h2>
          <p className="text-gray-500 text-center text-sm mb-10">Tout ce dont vous avez besoin en un seul endroit</p>
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {features.map((f) => (
              <div key={f.title} className="bg-white rounded-2xl p-6 flex gap-4 items-start shadow-sm border border-gray-100">
                <div className="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                  {f.icon}
                </div>
                <div>
                  <h3 className="font-semibold text-gray-800 mb-1">{f.title}</h3>
                  <p className="text-gray-500 text-sm leading-relaxed">{f.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── CTA ── */}
      <section className="py-16 px-4 bg-white text-center">
        <div className="max-w-xl mx-auto">
          <div className="inline-flex items-center justify-center w-14 h-14 bg-blue-100 rounded-2xl mb-5">
            <span className="text-2xl">⚡</span>
          </div>
          <h2 className="text-2xl font-bold text-gray-800 mb-3">Prêt à commencer ?</h2>
          <p className="text-gray-500 text-sm mb-7">
            Créez votre compte gratuitement et commencez à réserver vos appareils électroniques dès aujourd'hui.
          </p>
          <div className="flex flex-col sm:flex-row gap-3 justify-center">
            <button
              onClick={() => navigate("/login")}
              className="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition-colors shadow-md shadow-blue-200"
            >
              Créer un compte
            </button>
            <button
              onClick={() => navigate("/login")}
              className="border border-blue-200 text-blue-600 hover:bg-blue-50 font-semibold px-8 py-3 rounded-xl transition-colors"
            >
              Se connecter
            </button>
          </div>
        </div>
      </section>

      {/* ── FOOTER ── */}
      <footer className="bg-blue-700 text-blue-100 py-6 px-4 text-center text-sm">
        <p>© 2026 TechLocal — Marketplace de recherche et réservation d'appareils électroniques</p>
      </footer>

    </div>
  );
}