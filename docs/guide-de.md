# Anleitung — Builder Template Categories

> Die Entwicklung von Builder Template Categories wurde mit Version 1.9.0 eingestellt. Das Plugin ist überholt: Seine ursprünglichen Aufgaben übernehmen heute WordPress und moderne Builder; zugleich haben sich die Arbeitsabläufe verändert. Falls nötig, erscheinen ausschließlich Sicherheitsupdates — längstens bis zum 31.12.2027.

Empfohlen: [Builder Content Guide](https://github.com/deckerweb/builder-content-guide).

## Builder-Kategorien und WordPress-Vorlagen-Kategorien

**Builder-Kategorien** ist die gemeinsame Taxonomie dieses Plugins für unterstützte Vorlagenbibliotheken. **Vorlagen-Kategorien** ist die separate WordPress-Taxonomie für gespeicherte Patterns. Im Vorlageneditor können beide erscheinen. Die neue Bezeichnung verändert weder Taxonomie-Kennungen noch vorhandene Zuordnungen; beide Systeme werden nicht automatisch synchronisiert.


## Installation und Nutzung

1. ZIP unter **Plugins → Installieren → Plugin hochladen** installieren.
2. Aktivieren und die Vorlagenbibliothek öffnen.
3. Im Untermenü **Builder-Kategorien** die gewünschten Kategorien anlegen.
4. In der Vorlagenübersicht Kategorien zuweisen und über das Dropdown filtern.

## Verbleibende Integrationen

WordPress user patterns (`wp_block`), Elementor, Bricks, Beaver Builder / Beaver Themer, Divi, Oxygen Classic, Avada, GeneratePress Elements, Astra Pro.

Unterstützt wird die WordPress-Admin-Organisation. Kategorien werden nicht automatisch in die native Bibliothek eines Builders übernommen. Oxygen 6 ist nicht enthalten. Integrationseinträge werden nur für vorhandene Beitragstypen registriert.

## Update auf 1.9.0

72 frühere Integrationsdateien entfallen, darunter Formulare, Felder, Snippets, Scripts, kleinere Themes und Builder-Add-ons. Bestehende Zuordnungen bleiben gespeichert. Bei Bedarf kann ein Entwickler die bestehende Integrationsschnittstelle verwenden. Die Entfernung ist kein automatischer Datenumzug.

## FAQ

### Warum endet die Entwicklung?

WordPress und moderne Builder bieten heute eigene Bibliotheken und Organisationsfunktionen. Das Plugin wird mit 1.9.0 funktional abgeschlossen.

### Gibt es noch Updates?

Nur erforderliche Sicherheitsupdates, längstens bis 31.12.2027. Neue Funktionen sowie allgemeine Kompatibilitäts- und Fehlerkorrekturen sind danach nicht geplant.

### Was passiert mit meinen Kategorien?

Vorhandene Kategorien und Zuordnungen bleiben erhalten, auch bei Deaktivierung oder Deinstallation. Für entfernte Integrationen fehlt die Oberfläche; die Zuordnungen werden nicht gelöscht.

### Was muss ich vor dem Update prüfen?

Sichere Datenbank und Plugin-Dateien. Prüfe die höheren Mindestversionen und ob deine Integration weiterhin enthalten ist. Teste die Aktualisierung zuerst auf einer Testwebsite.

### Wer darf Kategorien verwenden?

Standardmäßig Benutzer mit edit_theme_options. Die Berechtigung ist filterbar. Öffentliche Besucher und normale Redakteure können interne Kategorien nicht über REST lesen oder ändern.

### Ersetzt Builder Content Guide dieses Plugin?

Es ist ein eigenständiges Plugin für verständliche Bearbeitungshinweise und Verweise auf Website-Bausteine. Es gibt keine automatische Migration der Kategorien.

### Funktioniert Multisite?

Einzel- und Netzwerkaktivierung werden unterstützt. Jede Website hat ihre eigenen Kategorien; neue Websites werden bei aktiver Netzwerkfreigabe initialisiert.

Die vollständige Anleitung einschließlich Entwicklerhinweisen steht in der [Dokumentation](guide-de.md).

## Entwickler

`btc/filter/integrations/all` receives and returns an array keyed by integration ID. Each integration declares string values for `label`, `submenu_hook`, `post_type`, `template_label`, `admin_url`. Non-existent post types and malformed entries are skipped. Register the filter before `init` priority 20. Late post-type registration is also handled. `btc/filter/capability/submenu` changes the management and assignment capability. `btc/filter/taxonomy/labels` and `btc/filter/taxonomy/args` customize the shared taxonomy. These extension points are for trusted PHP code; lowering capabilities changes the security model.

## Daten und Datenschutz

Kategorien und Beziehungen liegen in den WordPress-Taxonomietabellen. Keine Telemetrie; kein automatischer Datentransfer zu anderen Plugins. Deaktivierung und Deinstallation behalten Kategorien und Beziehungen. Externe Links werden nur auf Wunsch geöffnet. Keine neuen Frontend-Skripte oder Styles.

Vorgabekategorien werden nur bei einer leeren Sammlung angelegt. Bestehende eigene oder übersetzte Kategorien werden bei erneuter Aktivierung nicht aufgefüllt.

Gespeicherte WordPress-Vorlagen sind direkt unter **Vorlagen** im Admin-Menü erreichbar: **Alle Vorlagen**, **Vorlage hinzufügen** und **Builder-Kategorien**. Nur von Themes oder Plugins bereitgestellte Patterns bleiben im nativen Vorlagen-Inserter. Es gelten weiterhin die WordPress-Bearbeitungsrechte.

Builder-Kategorien gehören zu diesem Plugin und sind unabhängig von den WordPress-Vorlagen-Kategorien. Bestehende Kategorien und Zuordnungen bleiben erhalten.

Die Verwaltung der Builder-Kategorien zeigt die auf dieser Website verfügbaren Vorlagenbibliotheken mit Links zu ihren Übersichten und aufklappbaren technischen Beitragstypen. Diese Information sehen nur Benutzer mit der Berechtigung für Builder-Kategorien.

## Wartungsupdate 1.9.2

Updater 2.2.1 behebt die Update-Verarbeitung bei gleichzeitig geladenen älteren Updater-Kopien. Library 1.1.0, Funktionen, Einstellungen und Mindestanforderungen bleiben unverändert.

## Wartungsupdate 1.9.1

Version 1.9.1 ergänzt deckerweb Library 1.1.0 und deckerweb Updater 2.2.0 als ausdrücklich zugelassene Wartungsausnahme. Erforderlich ist jetzt PHP 8.1 oder neuer; WordPress 7.0 bleibt die Mindestversion. Der Funktionsstopp und das Ende möglicher Sicherheitsupdates am 31.12.2027 bleiben bestehen.

Die gemeinsame Library ist über Plugins hinzufügen erreichbar und unter Einstellungen → deckerweb Library ausblendbar. Ihr Online-Katalog ist standardmäßig ausgeschaltet. Wird er eingeschaltet, wird ein öffentlicher Katalog von GitHub geladen. Die Installation eines ausgewählten Plugins lädt dessen freigegebenes Paket; die Aktivierung ist ein eigener Schritt. Native Updates können GitHub kontaktieren und Release-ZIPs herunterladen. Dabei sieht die Gegenstelle die anfragende IP-Adresse; Telemetrie wird nicht ergänzt. Öffentliche Updates benötigen kein Token.

Gemeinsame Library-Einstellungen bleiben bei Deaktivierung und standardmäßig bei Deinstallation erhalten. Die Entfernung des letzten einbindenden Plugins bereinigt Komponenten-Caches und temporäre Dateien; eine optionale Einstellungslöschung richtet sich nach der Library-Vorgabe. Andere installierte Plugins, Kategorien und Inhalte bleiben erhalten.

Enthalten sind deckerweb Library 1.1.0 und deckerweb Updater 2.2.1 von David Decker – DECKERWEB unter GPL-2.0-or-later. Quellen: https://github.com/deckerweb/deckerweb-plugin-library und https://github.com/deckerweb/deckerweb-updater.

[Vollständige Anleitung und Fragen nach Themen](https://github.com/deckerweb/builder-template-categories/wiki/Deutsch).
