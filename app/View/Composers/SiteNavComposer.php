<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\ExpertisePole;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SiteNavComposer
{
    public function compose(View $view): void
    {
        $view->with([
            'navCategories' => $this->categories(),
            'navExpertises' => $this->expertises(),
        ]);
    }

    /** @return Collection<int, Category> */
    private function categories(): Collection
    {
        try {
            return Category::query()->orderBy('sort_order')->orderBy('name')->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** @return Collection<int, ExpertisePole> */
    private function expertises(): Collection
    {
        try {
            return ExpertisePole::query()->published()->orderBy('sort_order')->get();
        } catch (\Throwable) {
            return collect();
        }
    }
}
