<?php
session_start(); // Ensure session is started
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Pishi Games</title> <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        /* Make sure your theme variables are defined, either here or in style.css */
        /* Example (add this to style.css or keep here if not global): */
        :root {
            --background-color: #1a1a1a; /* General body background */
            --text-color: #cccccc; /* General light text */
            --accent-color: #00bcd4; /* Teal/Cyan accent */
            --accent-hover-color: #0097a7; /* Darker teal on hover */
            --container-bg-color: #1e1e1e; /* Background for main sections/cards */
            --border-color: #555; /* Subtle border color */
            --shadow-dark: rgba(0, 0, 0, 0.6); /* Darker shadow */
            --shadow-accent: rgba(0, 188, 212, 0.4); /* Accent colored shadow */
        }

        body {
             font-family: sans-serif; /* Or your preferred font */
             background-color: var(--background-color);
             color: var(--text-color);
             margin: 0;
             padding: 0;
             min-height: 100vh;
             display: flex;
             flex-direction: column;
         }

        /* Main container for the contact content */
        .contact-container {
            max-width: 1200px; /* Same max-width as other sections */
            margin: 2rem auto; /* Center the block and add space */
            padding: 30px; /* Increased padding */
            background-color: var(--container-bg-color);
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 8px 20px var(--shadow-dark); /* Enhanced shadow */
            color: var(--text-color);
            text-align: center; /* Center overall content */
            flex-grow: 1; /* Allow it to take available space */
        }

        /* Style for the main title */
        .contact-container h2 {
            text-align: center;
            color: var(--accent-color);
            margin-top: 0;
            margin-bottom: 2.5rem; /* More space below title */
            font-size: 2.5rem; /* Larger font size */
            text-shadow: 0 0 10px var(--shadow-accent); /* Enhanced shadow */
            line-height: 1.2;
        }

        /* Container for map and info sections */
        .contact-content {
            display: flex; /* Use Flexbox */
            flex-direction: column; /* Stack vertically by default */
            gap: 40px; /* Space between map and info sections */
            align-items: flex-start; /* Align items to the start */
        }

        /* Styles for the Map section */
        .contact-map {
            flex: 1; /* Allow map section to grow */
            min-width: 300px; /* Minimum width before wrapping */
            /* No need for background/padding if iframe is styled */
        }

        /* Styles for the iframe map */
        .contact-map iframe {
            display: block;
            width: 100%; /* Fill the container width */
            height: 400px; /* Adjust height as needed */
            /* Remove max-width here, let the container control width */
            margin: 0 auto; /* Center if container is wider */
            border: 2px solid var(--accent-color);
            border-radius: 8px;
            box-shadow: 0 0 15px var(--shadow-accent);
            aspect-ratio: 16 / 9; /* Maintain aspect ratio on resize */
            object-fit: cover; /* Ensure map covers the frame area */
        }

        /* Styles for the Contact Info section */
        .contact-info {
             flex: 1; /* Allow info section to grow */
             min-width: 250px; /* Minimum width before wrapping */
             text-align: left; /* Align text left within this section */
             padding: 20px; /* Padding inside info box */
             background-color: var(--container-bg-color); /* Optional: Add background if you want a distinct box */
             border-radius: 8px;
             /* box-shadow: 0 4px 10px rgba(0,0,0,0.3); */ /* Optional shadow */
             border: 1px solid var(--border-color); /* Optional subtle border */
        }

        /* Style for the info section title */
        .contact-info h3 {
            color: var(--accent-color);
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            border-bottom: 2px solid var(--accent-color); /* Underline title */
            padding-bottom: 10px;
            display: inline-block; /* Make border only as wide as text */
            text-shadow: 0 0 5px rgba(0, 188, 212, 0.3);
        }


        /* Styles for paragraphs in info section */
        .contact-info p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--text-color);
            word-break: break-word; /* Prevent long emails/addresses from overflowing */
        }

        /* Style for links in info section (Redes) */
        .contact-info a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease, text-decoration 0.3s ease;
            margin-right: 15px; /* Space between links */
            font-weight: bold;
        }

        .contact-info a:hover {
            color: var(--accent-hover-color);
            text-decoration: underline;
        }

        /* Add icons to contact details for visual appeal */
        .contact-info p i {
            margin-right: 10px; /* Space between icon and text */
            color: var(--accent-color); /* Accent color for icons */
            width: 20px; /* Fixed width for alignment */
            text-align: center;
        }


        /* Responsive adjustments */
        @media (min-width: 800px) {
            .contact-content {
                flex-direction: row; /* Side-by-side on larger screens */
                align-items: stretch; /* Make sections fill height */
            }

             .contact-map, .contact-info {
                 flex: 1; /* Give both sections equal flex growth */
                 min-width: 0; /* Allow sections to shrink below content size if needed */
             }

            .contact-map iframe {
                 height: 450px; /* Slightly taller map on larger screens */
            }
        }

        @media (max-width: 600px) {
             .contact-container {
                 padding: 20px; /* Less padding on smaller screens */
                 margin: 1rem auto;
             }

             .contact-container h2 {
                 font-size: 2rem;
                 margin-bottom: 2rem;
             }

             .contact-content {
                 gap: 30px; /* Reduced space between sections */
             }

             .contact-info {
                 padding: 15px;
             }

             .contact-info h3 {
                 font-size: 1.5rem;
                 margin-bottom: 1rem;
                 padding-bottom: 5px;
             }

             .contact-info p {
                 font-size: 1rem;
                 margin-bottom: 0.8rem;
             }

             .contact-map iframe {
                 height: 300px; /* Shorter map on very small screens */
                 aspect-ratio: auto; /* Let height be fixed on small screens */
             }
        }

         /* Add more specific mobile adjustments if needed */
         @media (max-width: 400px) {
              .contact-container h2 {
                  font-size: 1.8rem;
              }
              .contact-info p {
                  font-size: 0.95rem;
              }
               .contact-info a {
                   margin-right: 10px;
               }
         }

    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="contact-container">
        <h2>Comunícate con Nosotros</h2>

        <div class="contact-content">
            <section class="contact-map">
                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3221.754076079539!2d-71.65749342349916!3d-35.425906672669886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x966643001c174469%3A0x77d388b7c8b9a668!2sUniversidad%20Santo%20Tom%C3%A1s%20Talca!5e0!3m2!1ses-419!2scl!4v1716091016679!5m2!1ses-419!2scl"
                        height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </section>

            <section class="contact-info">
                <h3>Detalles de Contacto</h3>
                <p>
                    <i class="fas fa-share-alt"></i> Redes:
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#" aria-label="Whatsapp"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                </p>
                <p><i class="fas fa-envelope"></i> Correo Electrónico: contacto@empresa.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Dirección: Calle 123, Ciudad, Estado, Código Postal</p>
                <p><i class="fas fa-phone"></i> Teléfono: 555-555-5555</p>
                <p><i class="fas fa-clock"></i> Horario de atención: Lunes a Viernes de 9:00 am a 5:00 pm</p>
            </section>
        </div>

        </div>

    </body>
</html>