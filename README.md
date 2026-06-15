# Widerrufsbutton für Shopware 5 – Pflicht ab 19. Juni 2026 (§ 356a BGB)

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Shopware](https://img.shields.io/badge/Shopware-5.6%20–%205.7-189EFF.svg)](https://www.shopware.com)
[![PHP](https://img.shields.io/badge/PHP-7.2%2B-777BB4.svg)](https://www.php.net)

**Kostenloses Open-Source-Plugin, das den ab dem 19.06.2026 gesetzlich vorgeschriebenen Widerrufsbutton in deinem Shopware-5-Shop umsetzt** – inklusive Footer-Button „Vertrag widerrufen", digitalem Widerrufsformular, Bestätigungsschritt und automatischer Eingangsbestätigung per E-Mail.

> Ab dem **19. Juni 2026** müssen Online-Shops in der EU einen leicht zugänglichen **Widerrufsbutton** bereitstellen (§ 356a BGB n.F., Umsetzung der **EU-Richtlinie 2023/2673**). Dieses Plugin liefert die dafür nötige Funktion für Shopware 5 – ohne Abo, ohne Lizenzkosten.

---

## ⚖️ Hinweis: keine Rechtsberatung

Dieses Plugin ist eine **technische Hilfe** zur Umsetzung der gesetzlichen Anforderungen und **ersetzt keine Rechtsberatung**. Die konkrete rechtssichere Ausgestaltung (Texte, Fristen, Rückabwicklung) solltest du mit einer Rechtsberatung bzw. einem Dienst wie der IT-Recht Kanzlei abstimmen.

## Was ist der Widerrufsbutton und ab wann ist er Pflicht?

Mit der „Modernisierungs-Richtlinie" (EU 2023/2673) wird in Deutschland über **§ 356a BGB** eine **Widerrufsfunktion** verpflichtend: Verbraucher müssen Fernabsatzverträge **genauso einfach widerrufen** können, wie sie sie abgeschlossen haben – über eine gut sichtbare Schaltfläche. Die Pflicht gilt **ab dem 19. Juni 2026** für B2C-Shops, deren Sortiment ein Widerrufsrecht (14-Tage-Frist) auslöst – also für nahezu jeden klassischen Online-Shop. Sie ist **nicht** mit dem bereits seit 2022 bestehenden *Kündigungsbutton* (§ 312k BGB) zu verwechseln.

## Funktionsumfang

- ✅ **Footer-Button „Vertrag widerrufen"** – gut sichtbar, hervorgehoben, **ohne Login** auf jeder Seite erreichbar. Hängt sich per Template-Erweiterung in den Footer ein (überschreibt **keine** Theme-Dateien) und übernimmt automatisch die **Primärfarbe deines Themes**.
- ✅ **Digitales Widerrufsformular** – fragt **nur** das Nötige ab: Name, E-Mail, Bestell-/Vertragsnummer (optional) und Angaben zum Vertrag. **Kein Widerrufsgrund** (gesetzlich unzulässig). Bei eingeloggten Kunden vorausgefüllt.
- ✅ **Zwei-Stufen-Verfahren** – Eingabe → Prüfseite mit der gesetzlich geforderten Bestätigungsfunktion **„Widerruf bestätigen"**.
- ✅ **Automatische Eingangsbestätigung per E-Mail** – an den Kunden, mit **Datum und Uhrzeit** (dauerhafter Datenträger). Zusätzlich eine Benachrichtigung an den Shopbetreiber.
- ✅ **Dokumentation & Nachweis** – jeder Widerruf wird in der Datenbank gespeichert (`s_plugin_landolsi_widerruf`), die IP wird **anonymisiert** abgelegt (DSGVO).
- ✅ **Mehrsprachig vorbereitet**, **DSGVO-freundlich**, **kostenlos & quelloffen (MIT)**.

## Kompatibilität

| | |
|---|---|
| **Shopware** | 5.6 – 5.7 (entwickelt & getestet auf 5.7.16) |
| **PHP** | 7.2 – 7.4 |
| **Themes** | Standard *Responsive* sowie davon abgeleitete Themes (z. B. Clean-Theme) |

## Installation

**Per Kommandozeile (empfohlen):**

```bash
# Plugin-Ordner nach custom/plugins/LandolsiWiderrufsbutton/ kopieren, dann:
php bin/console sw:plugin:refresh
php bin/console sw:plugin:install --activate LandolsiWiderrufsbutton
php bin/console sw:cache:clear
php bin/console sw:theme:cache:generate
```

**Über das Backend:** *Einstellungen → Plugin-Manager* → Plugin hochladen, installieren & aktivieren → anschließend *Einstellungen → Caches/Performance* leeren und das Theme neu kompilieren.

## Konfiguration

- **Benachrichtigungs-E-Mail** (optional): An welche Adresse eingehende Widerrufe gemeldet werden. Leer = Standard-Shop-E-Mail.
- Die E-Mail-Vorlage der Eingangsbestätigung wird bei der Installation angelegt und ist unter *Einstellungen → E-Mail-Vorlagen* (`sLANDOLSIWIDERRUFCONFIRM`) frei anpassbar.

## Deinstallation

- **Backend (Plugin-Manager):** Beim Deinstallieren wirst du gefragt, ob die gespeicherten Daten erhalten bleiben sollen.
- **CLI:** `php bin/console sw:plugin:uninstall LandolsiWiderrufsbutton` entfernt dabei die Daten-Tabelle. **Beachte gesetzliche Aufbewahrungspflichten** (z. B. für Bestellungen/Rechnungen), bevor du Daten löschst.

## FAQ

**Ab wann ist der Widerrufsbutton Pflicht?**
Ab dem **19. Juni 2026** (§ 356a BGB n.F. / EU-Richtlinie 2023/2673).

**Gilt das auch für meinen normalen Warenshop?**
Ja. Die Pflicht trifft alle B2C-Fernabsatzverträge mit Widerrufsrecht – nicht nur Abos.

**Muss der Button im Footer stehen?**
Er muss **ständig verfügbar, gut lesbar und ohne Login erreichbar** sein. Der Footer ist die übliche, empfohlene Platzierung – genau dort setzt dieses Plugin an.

**Darf ich nach dem Widerrufsgrund fragen?**
Nein. Das Formular fragt bewusst **keinen Grund** ab.

**Kostet das Plugin etwas?**
Nein – es ist **kostenlos und Open Source** (MIT-Lizenz).

## Quellen & weiterführende Informationen

- Gesetzestext & Inkrafttreten: § 356a BGB (Umsetzungsgesetz zur EU-Richtlinie 2023/2673)
- IT-Recht Kanzlei, Verbraucherzentrale, IHK – Informationen zum Widerrufsbutton 2026

## Mitwirken

Pull Requests, Issues und Übersetzungen sind willkommen. Das Plugin wird „as is" bereitgestellt.

## Lizenz

[MIT](LICENSE) © [Landolsi Webdesign](https://landolsi.de)

---

*Keywords: Widerrufsbutton Shopware 5, Widerruf-Button Shopware, § 356a BGB, EU-Richtlinie 2023/2673, Widerrufsformular Shopware 5, Pflicht 19. Juni 2026, Vertrag widerrufen Button, Shopware 5 Plugin kostenlos, Widerrufsrecht Online-Shop.*
