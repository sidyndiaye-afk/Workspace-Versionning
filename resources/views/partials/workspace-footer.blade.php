@php($footerLinks = $footerLinks ?? [
    ['label' => 'Accueil', 'href' => route('onas.dashboard')],
    ['label' => 'Stratégie', 'href' => route('onas.projects.show', 'strategie')],
    ['label' => 'Créations', 'href' => route('onas.projects.show', 'creas-gamou')],
    ['label' => 'Vidéos', 'href' => route('onas.projects.show', 'gamou')],
    ['label' => 'Dev', 'href' => route('onas.projects.show', 'site-web')],
])
<footer class="border-t border-[#213327] bg-[#11231B] text-[#E6F3DB]">
    <div class="mx-auto flex w-full max-w-[1440px] flex-col gap-6 px-6 py-10 sm:px-10 lg:px-16">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="space-y-3">
                <span class="text-xs font-semibold uppercase tracking-[0.28em] text-[#72D8D2]">
                    ONAS x Levell
                </span>
                <p class="max-w-lg text-sm text-[#B5C7B1]">
                    Suivi centralisé des dispositifs stratégiques, créatifs et digitaux déployés pour l’ONAS. Accédez en un clic
                    aux plans, livrables et campagnes livrées.
                </p>
            </div>
            <nav aria-label="Navigation pied de page">
                <ul class="flex flex-wrap gap-3 text-sm font-medium text-[#E6F3DB]">
                    @foreach ($footerLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="rounded-full border border-white/10 px-4 py-2 transition hover:border-white/30 hover:text-white">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="flex flex-col gap-2 border-t border-white/10 pt-4 text-xs text-[#7C8F81] md:flex-row md:items-center md:justify-between">
            <span>© {{ now()->year }} Levell — Direction artistique & digitale pour l’ONAS.</span>
            <span class="text-[#92B09F]">Mise à jour : données projet synchronisées en temps réel.</span>
        </div>
    </div>
</footer>
