import { useRef, useState } from "react";
import type { KeyboardEvent, ClipboardEvent } from "react";

interface OtpProps {
  onSubmit?: (code: string) => void;
  email?: string;
}

export default function Otp({ onSubmit, email = "exemple@email.com" }: OtpProps) {
  const [digits, setDigits] = useState<string[]>(Array(6).fill(""));
  const inputs = useRef<(HTMLInputElement | null)[]>([]);

  const handleChange = (index: number, value: string) => {
    const cleaned = value.replace(/\D/g, "").slice(-1);
    const updated = [...digits];
    updated[index] = cleaned;
    setDigits(updated);
    if (cleaned && index < 5) {
      inputs.current[index + 1]?.focus();
    }
  };

  const handleKeyDown = (index: number, e: KeyboardEvent<HTMLInputElement>) => {
    if (e.key === "Backspace" && !digits[index] && index > 0) {
      inputs.current[index - 1]?.focus();
    }
  };

  const handlePaste = (e: ClipboardEvent<HTMLInputElement>) => {
    e.preventDefault();
    const pasted = e.clipboardData.getData("text").replace(/\D/g, "").slice(0, 6);
    const updated = Array(6).fill("");
    pasted.split("").forEach((char, i) => { updated[i] = char; });
    setDigits(updated);
    const nextEmpty = pasted.length < 6 ? pasted.length : 5;
    inputs.current[nextEmpty]?.focus();
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const code = digits.join("");
    if (code.length === 6) onSubmit?.(code);
  };

  const isComplete = digits.every((d) => d !== "");

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center px-4">
      <div className="bg-white w-full max-w-md rounded-2xl shadow-xl p-8">

        {/* Icône + Titre */}
        <div className="text-center mb-8">
          <div className="inline-flex items-center justify-center w-14 h-14 bg-blue-600 rounded-xl mb-4">
            <svg className="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
          <h1 className="text-2xl font-bold text-gray-800">Vérification OTP</h1>
          <p className="text-gray-500 text-sm mt-2">
            Un code à 6 chiffres a été envoyé à
          </p>
          <p className="text-blue-600 font-medium text-sm mt-0.5">{email}</p>
        </div>

        {/* Cases OTP */}
        <form onSubmit={handleSubmit}>
          <div className="flex justify-center gap-3 mb-8">
            {digits.map((digit, index) => (
              <input
                key={index}
                ref={(el) => { inputs.current[index] = el; }}
                type="text"
                inputMode="numeric"
                maxLength={1}
                value={digit}
                onChange={(e) => handleChange(index, e.target.value)}
                onKeyDown={(e) => handleKeyDown(index, e)}
                onPaste={handlePaste}
                className={`w-12 h-14 text-center text-xl font-bold rounded-xl border-2 transition-all outline-none
                  ${digit
                    ? "border-blue-500 bg-blue-50 text-blue-700"
                    : "border-gray-200 bg-white text-gray-800"
                  }
                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200`}
              />
            ))}
          </div>

          {/* Bouton Vérifier */}
          <button
            type="submit"
            disabled={!isComplete}
            className={`w-full font-semibold py-2.5 rounded-xl transition-colors duration-200 shadow-md
              ${isComplete
                ? "bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white shadow-blue-200 cursor-pointer"
                : "bg-gray-100 text-gray-400 cursor-not-allowed shadow-none"
              }`}
          >
            Vérifier le code
          </button>
        </form>

        {/* Renvoyer le code */}
        <p className="text-center text-sm text-gray-500 mt-6">
          Vous n'avez pas reçu le code ?{" "}
          <button
            type="button"
            className="text-blue-600 font-medium hover:text-blue-700 hover:underline"
            onClick={() => console.log("Renvoyer OTP")}
          >
            Renvoyer
          </button>
        </p>
      </div>
    </div>
  );
}
