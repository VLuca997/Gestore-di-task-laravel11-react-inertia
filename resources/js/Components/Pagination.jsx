import { Link } from "@inertiajs/react";

// Definizione del componente Pagination che accetta un array di oggetti links
export default function     Pagination({ links }) {
    // Ritorno del componente
    return (
        // Contenitore per i link di navigazione, con stile centrato e margin-top 4
        <nav className="text-center mt-4">
            {/* Mappatura dell'array di links */}
            {links.map((link) => (
                // Creazione del link per ogni elemento dell'array
                <Link
                    // Impostazione del comportamento di scrolling del browser
                    preserveScroll
                    // URL del link, se non disponibile viene impostato come stringa vuota
                    href={link.url || ""}
                    // Chiave univoca per il link, basata sull'etichetta
                    key={link.label}
                    // Classi CSS per lo stile del link, variando in base allo stato
                    className={
                        // Se il link è attivo, applica lo stile di sfondo grigio scuro,
                        // altrimenti lascia lo sfondo vuoto o applica lo stile di hover
                        "inline-block py-2 px-3 rounded-lg text-gray-200 text-xs " +
                        (link.active ? "bg-gray-950 " : " ") +
                        (!link.url ? "!text-gray-500 cursor-not-allowed " : "hover:bg-gray-950 ")
                    }
                    // Contenuto HTML del link, impostato come etichetta del link
                    dangerouslySetInnerHTML={{__html: link.label}}
                ></Link>
            ))}
        </nav>
            //NON FUNZIONA!
    //     <nav className="text-center mt-4">
    //     {links.map(link =>(
    //         <Link>{link.label}</Link>
    //     ))}
    // </nav>
    )
}
