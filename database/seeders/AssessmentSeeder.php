<?php

namespace Database\Seeders;

use App\Models\AssessmentDimension;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Clear stale dimensions so old slugs don't accumulate.
        // Answers / attempts are user data and are NOT touched.
        AssessmentDimension::query()->delete();

        $dimensions = [
            [
                'name' => 'Problem–Market Fit',
                'question' => 'Is your innovation capable of solving a real problem faced by farmers or agricultural businesses?',
                'options' => [
                    ['A', 'No field validation has been conducted. The agricultural problem is still based on assumptions.', 1],
                    ['B', 'Interviews have been conducted with 1–5 farmers, confirming that the problem exists.', 2],
                    ['C', 'Interviews have been conducted with 5+ farmers, confirming the problem and gathering their feedback on the product.', 3],
                    ['D', 'The product has been tested at a minimum of 3 locations or with farmer groups.', 4],
                    ['E', 'Farmers are willing to purchase the product.', 5],
                ],
            ],
            [
                'name' => 'Target Segment',
                'question' => 'Is your solution affordable and easy to adopt for your target segment (in AgTech: smallholder farmers / livestock farmers)?',
                'options' => [
                    ['A', "No pricing has been established, and the target market's purchasing power has not been analyzed.", 1],
                    ['B', 'An initial price estimate has been developed, but it has not yet been linked to the target market\'s income level.', 2],
                    ['C', 'Willingness to pay has been discussed and pricing has been established, but there are no alternative payment models yet.', 3],
                    ['D', 'The pricing and payment model have been determined and tested with 5+ target users.', 4],
                    ['E', 'The pricing and payment model have been implemented, and target users are already making transactions.', 5],
                ],
            ],
            [
                'name' => 'Unit Economics',
                'question' => 'To what extent have the economic benefits or ROI of your innovation been demonstrated?',
                'options' => [
                    ['A', 'Benefit claims are still limited to technical features (IoT, AI, sensors); there is no benefit data yet.', 1],
                    ['B', 'Benefit claims have been validated through literature, but no field trials have been conducted.', 2],
                    ['C', 'Field trials have been conducted (e.g., 2 ponds, survival rate increased by 8%), but there is no control group yet.', 3],
                    ['D', 'There is evidence of positive impact across 1–5 users/locations based on before and after comparisons. ROI can be calculated.', 4],
                    ['E', 'There is documented evidence of positive impact across 5+ users/locations, and the ROI can be explained to users in simple terms.', 5],
                ],
            ],
            [
                'name' => 'Adoption',
                'question' => "Can your innovation be integrated into users' daily activities without requiring major changes to their existing workflows?",
                'options' => [
                    ['A', "No analysis of the users' workflow has been conducted. Everything has been designed from the innovator's perspective.", 1],
                    ['B', 'User workflow analysis has been conducted, but it has not yet been tested in the field.', 2],
                    ['C', 'User workflow analysis has been conducted and field tested with 1–5 users.', 3],
                    ['D', 'Users can operate the product independently after 1–2 training sessions.', 4],
                    ['E', 'Users have voluntarily, actively, and consistently adopted the innovation. Adoption rate is >70%.', 5],
                ],
            ],
            [
                'name' => 'Business Model',
                'question' => 'Who pays for your innovation, how do they pay, and is the business model commercially viable?',
                'options' => [
                    ['A', 'The business model has not yet been defined. There is no distinction between the User and the Payer.', 1],
                    ['B', 'A revenue stream has been planned, but the purchasing decision maker has not been clearly identified.', 2],
                    ['C', 'A specific payer has been identified. Initial discussions have taken place, but there is no commitment yet.', 3],
                    ['D', '1–3 payers have made payments (even at a pilot price). The model is operating on a recurring basis (>1 transaction).', 4],
                    ['E', 'Multiple payers are actively paying the full commercial price. The revenue stream is predictable.', 5],
                ],
            ],
            [
                'name' => 'Value Proposition',
                'question' => 'Does your innovation provide greater value than its adoption cost within a single usage cycle?',
                'options' => [
                    ['A', 'Cost per user has not been calculated; the benefits versus costs are unknown.', 1],
                    ['B', 'Benefits versus costs have been estimated, but the calculation is not yet based on real field data.', 2],
                    ['C', 'An initial accounting profit calculation (results – costs) has been conducted for 1–5 users.', 3],
                    ['D', 'Accounting profit has been calculated for 5+ users using data from more than 2 cycles.', 4],
                    ['E', 'Data from 10+ users shows positive and consistent economic profit over more than 2 cycles.', 5],
                ],
            ],
            [
                'name' => 'Distribution Channels',
                'question' => 'Do you have partners or distribution channels that can effectively reach your target customers?',
                'options' => [
                    ['A', 'There is no distribution plan. Users are assumed to come on their own.', 1],
                    ['B', 'A list of potential distribution channels has been identified, but no meetings or initial discussions have taken place.', 2],
                    ['C', 'Initial discussions have been held with 1–2 distribution channels showing interest, but there is no commitment yet.', 3],
                    ['D', '1 distribution channel is actively distributing the product. An informal agreement or MoU is in place.', 4],
                    ['E', '2+ distribution channels are actively distributing the product under formal agreements.', 5],
                ],
            ],
            [
                'name' => 'Ecosystem Partnerships',
                'question' => 'To what extent have the strategic partners needed to support the development and commercialization of your innovation been involved?',
                'options' => [
                    ['A', 'No potential partners have been identified. The focus is 100% on the technology.', 1],
                    ['B', 'A list of potential partners has been created, but there has been no active engagement.', 2],
                    ['C', 'Initial meetings have been held with 2–3 partners. There is interest, but no formal commitment.', 3],
                    ['D', '1–2 partners are making tangible contributions, such as providing user access, data, or technical validation.', 4],
                    ['E', 'There is an active partner network with at least 3 of the following: universities/research institutions, communities, integrators, financial institutions, or local government.', 5],
                ],
            ],
            [
                'name' => 'Team Capacity',
                'question' => 'Does your team possess technical, field, and commercial capabilities?',
                'options' => [
                    ['A', 'The team consists of only 1 person with no specialized expertise.', 1],
                    ['B', 'The team consists of 2–3 people, but does not yet cover all three areas: technical, field, and commercial expertise.', 2],
                    ['C', 'The team covers all three areas of expertise, but some members have overlapping roles.', 3],
                    ['D', 'The team covers all three areas of expertise, with no overlapping roles.', 4],
                    ['E', 'The team has a strong track record and has already completed a validation cycle.', 5],
                ],
            ],
            [
                'name' => 'Data Strategy',
                'question' => 'Do you have a clear plan for collecting, using, and protecting data?',
                'options' => [
                    ['A', 'There is no data collection plan. Data is considered a by-product rather than an asset.', 1],
                    ['B', 'A data collection plan exists, but it has not yet been implemented. There is no data storage system yet.', 2],
                    ['C', 'Pilot data has been collected in spreadsheets. There is awareness of privacy, but no formal policy yet.', 3],
                    ['D', 'A structured data storage system is in place. Data is regularly used to improve the product.', 4],
                    ['E', 'A formal data policy is available and understood by users. Data is used for product development, evidence generation, and partnerships.', 5],
                ],
            ],
        ];

        foreach ($dimensions as $order => $dim) {
            $dimension = AssessmentDimension::create([
                'name'       => $dim['name'],
                'slug'       => Str::slug($dim['name']),
                'sort_order' => $order + 1,
            ]);

            $question = $dimension->questions()->create([
                'question'   => $dim['question'],
                'sort_order' => 1,
            ]);

            foreach ($dim['options'] as $i => [$label, $text, $score]) {
                $question->options()->create([
                    'label'      => $label,
                    'text'       => $text,
                    'score'      => $score,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
