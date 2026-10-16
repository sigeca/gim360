#!/usr/bin/env python3
"""
generate_animations.py
Genera animaciones WebP (.webp) para todos los ejercicios del repositorio RepDB / Gim360.
- Extrae las animaciones 3D de alta definición desde repdb-preview.zip (22 ejercicios predeterminados).
- Genera animaciones fluidas de 8 fotogramas (inicio, transición concéntrica, pico, transición excéntrica)
  para todos los ejercicios que disponen de fotogramas de inicio (-start.webp) y final (-peak.webp).
- Procesa ejercicios isométricos (-main.webp).
- Mantiene compatibilidad con animacionejemplo.webp y crea directorio/enlace images/animations.
"""

import os
import sys
import glob
import zipfile
from PIL import Image

REPO_DIR = '/var/www/html/gim360/repositorio/ejercicios'
FLAT_DIR = os.path.join(REPO_DIR, 'repdb-free/images/flat')
PREVIEW_ZIP = os.path.join(REPO_DIR, 'repdb-preview.zip')
ANIM_DIR = os.path.join(REPO_DIR, 'repdb-free/images/animations')

def main():
    print("==================================================")
    print("  GENERADOR DE IMÁGENES ANIMADAS WEBP - GIM360   ")
    print("==================================================")
    
    if not os.path.isdir(FLAT_DIR):
        print(f"Error: No se encontró el directorio {FLAT_DIR}")
        sys.exit(1)

    # 1. Extraer animaciones 3D originales de repdb-preview.zip
    extracted_preview = 0
    if os.path.isfile(PREVIEW_ZIP):
        print("\n[1/4] Extrayendo animaciones 3D de repdb-preview.zip...")
        with zipfile.ZipFile(PREVIEW_ZIP, 'r') as z:
            for member in z.namelist():
                if member.startswith('images/animations/') and member.endswith('.webp'):
                    filename = os.path.basename(member)
                    target_path = os.path.join(FLAT_DIR, filename)
                    with z.open(member) as source, open(target_path, 'wb') as dest:
                        dest.write(source.read())
                    extracted_preview += 1
        print(f"  -> {extracted_preview} animaciones 3D extraídas en {FLAT_DIR}")
    else:
        print("\n[1/4] Archivo repdb-preview.zip no encontrado, omitiendo paso.")

    # Asegurar que animacioejemplo.webp, animacionejemplo.webp y barbell-reverse-lunge.webp estén sincronizados
    lunge_path = os.path.join(FLAT_DIR, 'barbell-reverse-lunge.webp')
    ejemplo_path = os.path.join(FLAT_DIR, 'animacioejemplo.webp')
    ejemplo_n_path = os.path.join(FLAT_DIR, 'animacionejemplo.webp')
    
    if os.path.isfile(lunge_path):
        if not os.path.exists(ejemplo_path):
            os.symlink('barbell-reverse-lunge.webp', ejemplo_path)
        if not os.path.exists(ejemplo_n_path):
            os.symlink('barbell-reverse-lunge.webp', ejemplo_n_path)
    elif os.path.isfile(ejemplo_path):
        if not os.path.exists(lunge_path):
            os.symlink('animacioejemplo.webp', lunge_path)
        if not os.path.exists(ejemplo_n_path):
            os.symlink('animacioejemplo.webp', ejemplo_n_path)

    # 2. Escanear todos los archivos en FLAT_DIR
    print("\n[2/4] Escaneando catálogo de ejercicios en images/flat...")
    files = glob.glob(os.path.join(FLAT_DIR, '*.webp'))
    exercises = {}
    
    for f in files:
        bn = os.path.basename(f)
        if bn in ('animacioejemplo.webp', 'animacionejemplo.webp'):
            continue
        if bn.endswith('-start.webp'):
            slug = bn[:-11]
            exercises.setdefault(slug, {})['start'] = bn
        elif bn.endswith('-peak.webp'):
            slug = bn[:-10]
            exercises.setdefault(slug, {})['peak'] = bn
        elif bn.endswith('-main.webp'):
            slug = bn[:-10]
            exercises.setdefault(slug, {})['main'] = bn
        else:
            slug = bn[:-5]
            exercises.setdefault(slug, {})['anim'] = bn

    start_peak_slugs = [s for s, data in exercises.items() if 'start' in data and 'peak' in data]
    main_only_slugs = [s for s, data in exercises.items() if 'main' in data and 'start' not in data]
    
    print(f"  -> Total de ejercicios identificados: {len(exercises)}")
    print(f"  -> Ejercicios con fase Inicio y Pico: {len(start_peak_slugs)}")
    print(f"  -> Ejercicios isométricos (solo main): {len(main_only_slugs)}")

    # 3. Generar animaciones fluidas para ejercicios con Start y Peak
    print("\n[3/4] Generando animaciones WebP para ejercicios con inicio y final...")
    generated_count = 0
    skipped_count = 0
    error_count = 0

    for i, slug in enumerate(sorted(start_peak_slugs), 1):
        anim_path = os.path.join(FLAT_DIR, f"{slug}.webp")
        
        # Verificar si ya existe una animación con más de 1 cuadro
        if os.path.isfile(anim_path):
            try:
                with Image.open(anim_path) as im:
                    if getattr(im, 'is_animated', False) and im.n_frames > 1:
                        skipped_count += 1
                        continue
            except Exception:
                pass  # Si el archivo está corrupto o no se puede leer, regenerarlo

        start_path = os.path.join(FLAT_DIR, f"{slug}-start.webp")
        peak_path = os.path.join(FLAT_DIR, f"{slug}-peak.webp")

        try:
            with Image.open(start_path) as im_start, Image.open(peak_path) as im_peak:
                start_rgba = im_start.convert('RGBA')
                peak_rgba = im_peak.convert('RGBA')

                # Si las dimensiones difieren, redimensionar pico a inicio
                if start_rgba.size != peak_rgba.size:
                    peak_rgba = peak_rgba.resize(start_rgba.size, Image.Resampling.LANCZOS)

                # Generar transiciones intermedias ponderadas (concentric & eccentric)
                b25 = Image.blend(start_rgba, peak_rgba, 0.25)
                b50 = Image.blend(start_rgba, peak_rgba, 0.50)
                b75 = Image.blend(start_rgba, peak_rgba, 0.75)

                # Secuencia de 8 fotogramas para ciclo completo
                frames = [start_rgba, b25, b50, b75, peak_rgba, b75, b50, b25]
                durations = [750, 80, 80, 80, 750, 80, 80, 80]

                frames[0].save(
                    anim_path,
                    format='WEBP',
                    save_all=True,
                    append_images=frames[1:],
                    duration=durations,
                    loop=0,
                    quality=82,
                    method=4
                )
                generated_count += 1
                if generated_count % 50 == 0 or generated_count == len(start_peak_slugs):
                    print(f"  [{i}/{len(start_peak_slugs)}] Progreso: {generated_count} animaciones generadas...")
        except Exception as e:
            print(f"  [ERROR] No se pudo generar animación para {slug}: {e}")
            error_count += 1

    print(f"\n  Resumen de generación:")
    print(f"    Animaciones generadas con éxito: {generated_count}")
    print(f"    Animaciones conservadas (preexistentes/3D): {skipped_count}")
    print(f"    Errores: {error_count}")

    # 4. Procesar ejercicios isométricos (-main.webp)
    print("\n[4/4] Procesando ejercicios isométricos (-main.webp)...")
    isometric_count = 0
    for slug in main_only_slugs:
        anim_path = os.path.join(FLAT_DIR, f"{slug}.webp")
        main_path = os.path.join(FLAT_DIR, f"{slug}-main.webp")
        if not os.path.exists(anim_path):
            try:
                # Copiar o enlazar para asegurar disponibilidad directa de {slug}.webp
                with open(main_path, 'rb') as src, open(anim_path, 'wb') as dst:
                    dst.write(src.read())
                isometric_count += 1
            except Exception as e:
                print(f"  [ERROR] No se pudo procesar isométrico {slug}: {e}")
    print(f"  -> {isometric_count} ejercicios isométricos vinculados a .webp")

    # 5. Configurar enlace repdb-free/images/animations -> flat
    if not os.path.exists(ANIM_DIR):
        try:
            os.symlink('flat', ANIM_DIR)
            print(f"\n  -> Enlace creado: {ANIM_DIR} -> flat")
        except Exception as e:
            print(f"  [AVISO] No se pudo crear symlink animations: {e}")

    # 6. Verificación final global
    print("\n==================================================")
    print("            VERIFICACIÓN GLOBAL FINAL             ")
    print("==================================================")
    all_webp = glob.glob(os.path.join(FLAT_DIR, '*.webp'))
    anim_webp = []
    for f in all_webp:
        bn = os.path.basename(f)
        if not (bn.endswith('-start.webp') or bn.endswith('-peak.webp') or bn.endswith('-main.webp')):
            anim_webp.append(bn)

    animated_valid = 0
    for bn in anim_webp:
        path = os.path.join(FLAT_DIR, bn)
        try:
            with Image.open(path) as im:
                if getattr(im, 'is_animated', False):
                    animated_valid += 1
        except Exception:
            pass

    print(f"Total de archivos .webp en images/flat: {len(all_webp)}")
    print(f"Total de archivos de ejercicio base (.webp): {len(anim_webp)}")
    print(f"Total de archivos con animación activa verificada: {animated_valid}")
    print("Proceso completado satisfactoriamente.")

if __name__ == '__main__':
    main()
