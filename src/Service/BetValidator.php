<?php

namespace App\Service;

use App\Errors\BetslipStructureMismatch;
use App\Errors\DuplicateSelectionFound;
use App\Errors\MaximumNumberOfSelections;
use App\Errors\MaximumOdds;
use App\Errors\MaximumStakeAmount;
use App\Errors\MaximumWinAmount;
use App\Errors\MinimumNumberOfSelections;
use App\Errors\MinimumOdds;
use App\Errors\MinimumStakeAmount;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidator;
use function MongoDB\BSON\toJSON;

class BetValidator
{
    /** @var BaseValidator $validator */
    private $validator;

    private $betParameters;

    public function __construct(BaseValidator $validator, ParameterBagInterface $parameterBag)
    {
        $this->validator = $validator;
        $this->betParameters = $parameterBag->get('bet');
    }

    public function validate(&$bet)
    {
        $violations = $this->validator->validate($bet, $this->getConstraints());

        $countable = is_array($violations) || $violations instanceof \Countable;
        if ($countable && count($violations) !== 0) {
            foreach($violations as $violation) {
                if(strpos($violation->getPropertyPath(),'selections][') >0 && !($violation->getConstraint()->payload instanceof BetslipStructureMismatch)) {
                    preg_match_all('/\[selections\]\[(\d+)\]/m',$violation->getPropertyPath(),$index);
                    $index = $index[1][0];
                    if(!array_key_exists('errors',$bet['selections'][$index])) {
                        $bet['selections'][$index]['errors'] = [];
                    }
                    $bet['selections'][$index]['errors'][] =  $violation->getConstraint()->payload;
                } else {
                    if(!array_key_exists('errors',$bet)) {
                        $bet['errors'] = [];
                    }
                    $bet['errors'][]  = $violation->getConstraint()->payload;
                }
            }
            if(!empty($bet['errors'])) {
                $bet['errors'] = array_unique($bet['errors']);
            }
            return false;
        }
        return true;
    }

    private function getConstraints()
    {
        return new Assert\Collection([
            'player_id' => new Assert\Optional([
                new Assert\NotNull(['payload' => new BetslipStructureMismatch()]),
                new Assert\Type(['type' => 'integer', 'payload' => new BetslipStructureMismatch()]),
            ]),
            'stake_amount' => new Assert\Optional([
                new Assert\NotNull(['payload' => new BetslipStructureMismatch()]),
                new Assert\Type(['type' => 'string', 'payload' => new BetslipStructureMismatch()]),
                new Assert\GreaterThanOrEqual(['value' => $this->betParameters['stake_amount']['min'], 'payload' => new MinimumStakeAmount($this->betParameters['stake_amount']['min'])]),
                new Assert\LessThanOrEqual(['value' => $this->betParameters['stake_amount']['max'], 'payload' => new MaximumStakeAmount($this->betParameters['stake_amount']['max'])]),
                new AppAssert\NumbersAfterDot(['max' => 2, 'payload' => new BetslipStructureMismatch()]),
                new AppAssert\WinLimit(['max' => $this->betParameters['max_win'], 'payload' => new MaximumWinAmount($this->betParameters['max_win'])])
            ]),
            'selections' => new Assert\Optional([
                new Assert\Type(['type' => 'array', 'payload' => new BetslipStructureMismatch()]),
                new Assert\Count(['min' => $this->betParameters['selections']['min_count'], 'payload' => new MinimumNumberOfSelections($this->betParameters['selections']['min_count'])]),
                new Assert\Count(['max' => $this->betParameters['selections']['max_count'], 'payload' => new MaximumNumberOfSelections($this->betParameters['selections']['max_count'])]),
                new Assert\All([
                    new Assert\Collection([
                        'id' => new Assert\Optional([
                            new Assert\NotNull(['payload' => new BetslipStructureMismatch()]),
                            new Assert\Type(['type' => 'integer', 'payload' => new BetslipStructureMismatch()]),
                            new AppAssert\UniqueElement(['field' => 'id', 'payload' => new DuplicateSelectionFound()])
                        ]),
                        'odds' => new Assert\Optional([
                            new Assert\NotNull(['message' => new BetslipStructureMismatch()]),
                            new Assert\Type(['type' => 'string',  'payload' => new BetslipStructureMismatch()]),
                            new Assert\GreaterThanOrEqual(['value' => $this->betParameters['selections']['min_odds'], 'payload' => new MinimumOdds($this->betParameters['selections']['min_odds'])]),
                            new Assert\LessThanOrEqual(['value' => $this->betParameters['selections']['max_odds'], 'payload' => new MaximumOdds($this->betParameters['selections']['max_odds'])]),
                            new AppAssert\NumbersAfterDot(['max' => 3, 'payload' => new BetslipStructureMismatch()])
                        ]),
                    ])
                ])
            ])
        ]);
    }
}
